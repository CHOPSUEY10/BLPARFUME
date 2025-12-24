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
            .summary-title{
                text-align: left;
                margin-left : 5%;

            }
            
            #summary-table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #summary-table td, #summary-table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #summary-table tr:nth-child(even){background-color: #f2f2f2;}

            #summary-table tr:hover {background-color: #ddd;}

            #summary-table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }

            #summary-table thead th {
                justify-content : flex-start;
                margin-left : 8%;
            }

            
            .monthly-sales-title{
                text-align: left;
                margin-left : 5%;
            }
            
             #monthly-sales-table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #monthly-sales-table td, #monthly-sales-table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            #monthly-sales-table tr:nth-child(even){background-color: #f2f2f2;}

            #monthly-sales-table tr:hover {background-color: #ddd;}

            #monthly-sales-table th {
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
        
        <div class ="summary-title">
            <h3> <?= $summary_title ?></h3>    
        </div>
        <table id="summary-table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Total Revenue</th>
                    <th>Total Pesanan</th>
                    <th>Rata - rata pesanan</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($finance as $fnc) : ?>
                        <tr>
                            <td> <?=$fnc['periode']?></td>
                            <td> <?=$fnc['total_revenue']?></td>
                            <td> <?=$fnc['total_orders']?></td>
                            <td> <?=$fnc['average_order']?></td>
                        </tr>
                    <?php endforeach ?>
            </tbody>
        </table>

        <div class ="monthly-sales-title">
            <h3> <?= $monthly_title ?></h3>    
        </div>
        <table id="monthly-sales-table">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Total Penjualan</th>
                    <th>Jumlah Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach($monthly_sales as $sale) : ?>
                        <td> <?=$sale['month_name']?></td>
                        <td> <?=$sale['total_sales']?></td>
                        <td> <?=$sale['total_orders']?></td>
                    <?php endforeach ?>
                </tr>
            </tbody>
        </table>                

    </body>
</html>