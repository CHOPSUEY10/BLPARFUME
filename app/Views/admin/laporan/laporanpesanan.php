<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title;?></title>
        <style>
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
        <div style="text-align:center">
            <h1> Laporan Pemesanan BL Parfume</h1>
        </div>
        <table id="table">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach($orders as $order) : ?>
                        <td scope="row"><?= $order['order_id'] ?></td>
                        <td><?= $order['nama'] ?></td>
                        <td><?= $order['email'] ?></td>
                        <td><?= $order['total_price'] ?></td>
                        <td><?= $order['status'] ?></td>
                        <td><?= $order['tanggal_transaksi'] ?></td>
                    <?php  endforeach ?>
                </tr>
            </tbody>
        </table>
    </body>
</html>