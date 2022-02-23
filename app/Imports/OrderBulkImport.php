<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\Package;
use App\Models\Receiver;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrderBulkImport implements ToModel, SkipsEmptyRows, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;
    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        /** @var User $user */
        $user = Auth::user();

        $pic_up_array = $this->data;
        foreach($pic_up_array as $pick_up){
            $pick_branch = $pick_up;
        }

        if($user->hasRole('Seller')){
            $seller = User::find($user->id)->seller;
            $waybill_details = Package::where([['waybill_id', $row['waybill_id']], ['seller_id', $seller->seller_id], ['package_used_status', 0]])->count();
            
        } else{
            $seller_id = $row['seller_id'];
            $waybill_details = Package::where([['waybill_id', $row['waybill_id']], ['seller_id', $seller_id], ['package_used_status', 0]])->count();
        }

        if ($waybill_details > 0) {

            DB::transaction(function () use ($row, $user, $seller_id, $pick_branch) {
                Package::find($row['waybill_id'])->update([
                    'package_used_status' => '1',
                ]);

                $receiver_info = Receiver::create([
                    'receiver_name' => $row['recipient_name'],
                    'receiver_contact' => $row['contact_no_1'],
                    'receiver_conatct_2' => $row['contact_no_2'],
                    'receiver_address' => $row['address'],
                ]);

                Order::create([
                    'status' => '1',
                    'cod_amount' => $row['cod_amount'],
                    'st_1_at' => date('Y-m-d H:i:s'),
                    'st_1_by' => $user->id,
                    'waybill_id' => $row['waybill_id'],
                    'receiver_id' => $receiver_info->receiver_id,
                    'seller_id' => $seller_id,
                    'pickup_branch_id' => $pick_branch,
                    'remark' => $row['remark']
                ]);
            });
        }
    }

    public function rules(): array
    {
        return [
            'waybill_id' => 'required|exists:packages|unique:orders',
            'seller_id' => 'required|exists:sellers',
            'cod_amount' => 'required|numeric|between:0,99999999.99',
            'recipient_name' => 'required',
            'contact_no_1' => 'required|min:9|max:10',
            'contact_no_2' => 'nullable|min:9|max:10',
            'address' => 'required',
            'remark' => 'nullable',
        ];       
    }
}
