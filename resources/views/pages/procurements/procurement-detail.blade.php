<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bon de commande</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
        *{
            margin: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }
        body{
            /* background: #E0E0E0; */
            font-family: 'Roboto', sans-serif;
        }
        ::selection {background: #f31544; color: #FFF;}
        ::moz-selection {background: #f31544; color: #FFF;}
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .col-left {
            float: left;
        }
        .col-right {
            float: right;
        }
        h1{
            font-size: 1.5em;
            color: #444;
        }
        h2{font-size: .9em;}
        h3{
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
        p{
            font-size: .75em;
            color: #666;
            line-height: 1.2em;
        }
        a {
            text-decoration: none;
            color: #00a63f;
        }

        #invoiceholder{
            width:100%;
            padding: 50px 0;
        }
        #invoice{
            position: relative;
            margin: 0 auto;
            width: 700px;
            background: #FFF;
        }

        [id*='invoice-']{
            padding: 20px;
        }

        #invoice-top{border-bottom: 2px solid black; margin-top: 5px; width: 100%}

        .logo{
            display: inline-block;
            vertical-align: middle;
            width: 110px;
            overflow: hidden;
        }
        .info{
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px;
        }
        .logo img,
        .clientlogo img {
            width: 100%;
        }
        /* .clientlogo{
            display: inline-block;
            vertical-align: middle;
            width: 50px;
        } */
        .clientinfo {
            display: inline-block;
            vertical-align: middle;
            /* margin-left: 20px */
        }
        .title{
            float: right;
        }
        .title p{text-align: right;}
        #message{margin-bottom: 30px; display: block;}
        h2 {
            margin-bottom: 5px;
            color: #444;
        }
        .col-right td {
            color: #666;
            padding: 5px 8px;
            border: 0;
            font-size: 0.75em;
            border-bottom: 1px solid #eeeeee;
        }
        .col-right td label {
            margin-left: 5px;
            font-weight: 600;
            color: #444;
        }
        .cta-group a {
            display: inline-block;
            padding: 7px;
            border-radius: 4px;
            background: rgb(196, 57, 10);
            margin-right: 10px;
            min-width: 100px;
            text-align: center;
            color: #fff;
            font-size: 0.75em;
        }
        .cta-group .btn-primary {
            background: #00a63f;
        }
        .cta-group.mobile-btn-group {
            display: none;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid;
        }
        td{
            padding: 10px;
            border-bottom: 1px solid #cccaca;
            font-size: 0.70em;
            text-align: left;
        }

        .tabletitle th {
            border-bottom: 2px solid #ddd;
            text-align: right;
        }
        .tabletitle th:nth-child(2) {
            text-align: left;
        }
        th {
            font-size: 0.7em;
            text-align: left;
            padding: 5px 10px;
        }
        .item{width: 50%;}
        .list-item td {
            text-align: right;
        }
        .list-item td:nth-child(2) {
            text-align: left;
        }
        .total-row th,
        .total-row td {
            text-align: right;
            font-weight: 700;
            font-size: .75em;
            border: 0 none;
        }

        footer {
            border-top: 1px solid #eeeeee;;
            padding: 10px 10px;
        }

        @media screen and (max-width: 767px) {
            h1 {
                font-size: .9em;
            }
            #invoice {
                width: 100%;
            }
            #message {
                margin-bottom: 20px;
            }
            [id*='invoice-'] {
                padding: 20px 10px;
            }
            .logo {
                width: 140px;
            }
            .title {
                float: none;
                display: inline-block;
                vertical-align: middle;
                margin-left: 40px;
            }
            .title p {
                text-align: left;
            }
            .col-left,
            .col-right {
                width: 100%;
            }
            /* .table {
                margin-top: 20px;
            } */
            #table {
                white-space: nowrap;
                overflow: auto;
            }
            td {
                white-space: normal;
            }
            .cta-group {
                text-align: center;
            }
            .cta-group.mobile-btn-group {
                display: block;
                margin-bottom: 20px;
            }
            /*==================== Table ====================*/
            .table-main {
                border: 0 none;
            }
            .table-main thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }
            .table-main tr {
                border-bottom: 2px solid #eee;
                display: block;
                margin-bottom: 20px;
            }
            .table-main td {
                font-weight: 700;
                display: block;
                padding-left: 40%;
                max-width: none;
                position: relative;
                border: 1px solid #cccaca;
                text-align: left;
            }
            .table-main td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: normal;
                text-transform: uppercase;
            }
            .total-row th {
                display: none;
            }
            .total-row td {
                text-align: left;
            }
            footer {text-align: center;}
        }

    </style>
</head>
<body>
<div id="invoiceholder">
    <div id="invoice">
        <div id="invoice-top">
            <div class="logo"><img src="{{ $image }}" alt="Logo" /></div>
            <div class="title">
                <h1>COMMANDE N° <span class="invoiceVal invoice_num">{{ $procurement->reference }}</span></h1>
                <p>Date: <span id="invoice_date">{{ Date::parse($procurement->add_date)->locale('fr')->format('l j F Y H:m:s') }}</span><br>
                </p>
            </div>
        </div>
        <div id="invoice-mid">

            <div class="clearfix">
                <div class="col-left">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                {{ $procurement->depotStockage->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ $procurement->depotStockage->adresse_depot }} / {{ $procurement->depotStockage->ville_depot }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ $procurement->depotStockage->telephone_depot }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-right">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><span>Fournisseur</span>
                                <label >
                                    {{ $procurement->fournisseur->nom }} {{ $procurement->fournisseur->prenom }}
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><span>Numéro</span>
                                <label>
                                    {{ $procurement->fournisseur->phone }}
                                </label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="invoice-bot">
            <div id="table">
                <table class="table-main">
                    <thead>
                    <tr class="tabletitle">
                        <th class="w-50">Nom produit</th>
                        <th class="w-50">unité</th>
                        <th class="w-50">Qté commandée</th>
                      {{--  <th class="w-50">Qté réceptionnée</th>--}}
                        <th class="w-50">Prix unitaire</th>
                        <th class="w-50">Total</th>
                    </tr>
                    </thead>
                    @foreach ($procurement_products as $item)
                        <tr>
                            <td>{{ $item->produit->nom_produit }}</td>
                            <td>{{ $item->product_unit->unite->name }}</td>
                            <td>{{ number_format($item->quantity) }}</td>
                           {{-- <td>{{ number_format($item->quantity_received) }}</td>--}}
                            <td>{{ number_format($item->purchase_price) }}</td>
                            <td>{{ number_format($item->total_purchase_price) }}</td>
                        </tr>
                    @endforeach
                    <tr class="list-item">
                        {{--<td></td>
                        <td></td>
                        <td></td>
                        <td></td>--}}
                        <td class="fw-bold" colspan="4">TOTAL</td>
                        <td>{{ number_format($procurement->cost) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>

