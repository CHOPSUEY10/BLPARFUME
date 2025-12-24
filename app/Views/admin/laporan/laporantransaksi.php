<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title;?></title>
        <style>
            .page-title {
                text-align: center;
            }

            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="page-title">
            <h1> Laporan Transaksi BL Parfume</h1>
        </div>
        <table id="table">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Metode</th>
                    <th>Nominal</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totaltransactions = 0;
                    foreach($transactions as $tr) : 
                ?>
                    <tr>
                        <td><?= $tr['order_id'] ?></td>
                        <td><?= $tr['nama'] ?></td>
                        <td><?= $tr['email'] ?></td>
                        <td><?= $metode ?></td>
                        <td><?= $tr['total_price'] ?></td>
                        <td><?= $tr['tanggal_transaksi'] ?></td>
                    </tr>
                    <?php $totaltransactions += $tr['total_price']?>
                <?php endforeach ?>
                <tr>
                    <td colspan="4"><strong>Total Transaksi bulan ini</strong></td>
                    <td><strong><?= number_format($totaltransactions, 0, ',', '.') ?></strong></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>