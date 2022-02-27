<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Waybill</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        @media print {
            .pagebreak {

                page-break-after: always;
            }
        }

        .table {
            max-height: 1754px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-6">
                <table class="table table-bordered text-center">
                    <tbody>
                        <tr>
                            <td style="width: 180px;"><img src="{{ url('logo.png') }}" alt="Quick Delivery Service"
                                    style="width:150px; height:30px;"></td>
                            <td><b style="font-size: 9px;">WayBill Number</b> <br> 1122</td>
                            <td><b style="font-size: 9px;">Date</b><br> 2022 Jan 22</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Waybill ID</td>
                        </tr>
                        <tr>
                            <td>Address
                            </td>
                            <td class="text-left" colspan="2"><b>Recipient :</b>Dhanushka, 398/E, Kahangama <br>
                                0758982868</td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="3"><b>Seller :</b>Hidramani, Kuruwita <br> 0758982868</td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="3"><b>COD Amount :</b> 1222 LKR</td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="3"><b>Package weight:</b> 10Kg</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left"><b>Package Description:</b> Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum amet optio assumenda a dolor! Harum at perspiciatis voluptatibus impedit fugiat, ipsa perferendis ut, consequuntur neque eligendi reprehenderit totam eveniet aut.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagebreak"></div>
    </div>
</body>
<script>
    print();
</script>

</html>