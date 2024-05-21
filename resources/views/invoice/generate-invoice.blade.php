<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>facture N° {{ $sale->id }}-{{ $sale->created_at->format('Y') }}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        label {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }

        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }

        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }

        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }

        .order-details tbody tr td:nth-child(1) {
            width: 23%;
        }

        .order-details tbody tr td:nth-child(3) {
            width: 23%;
        }

        .text-start {
            text-align: left;
        }

        .company {
            text-align: left;
            margin-left: 10px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .no-border {
            border: 1px solid #fff !important;
        }

        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }

        .w-top-bor {
            border-top: 1px solid white;
        }

        .w-left-bor {
            border-left: 1px solid white;
        }

        .w-bot-bor {
            border-bottom: 1px solid white;
        }

        .w-right-bor {
            border-right: 1px solid white;
        }

        .main_logo {
            width: 70px;
            height: 70px;
            margin-left: 20px;
            display: inline-block;
            vertical-align: middle;
        }

        .center2 {
            display: inline-block;
            vertical-align: middle;
            text-align: left;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <?php
    $command = $sale->command;
    $client = $command->client;
    $productsWithQuantities = $command->productsAndQuantities;
    $tva = round(0.19 * $command->total_price, 2);
    $total = $command->total_price + $tva;
    if ($command->payment_method == 'Espèce') {
        $timbre = round(0.01 * $total, 2);
        $total += $timbre;
    }
    ?>

    <table class="order-details">
        <thead>
            <tr>
                <th style="margin-top: 10px;" width="50%" colspan="2">
                    <img class="main_logo" src="imgs/icons/djezzy.png" alt="Logo">
                    <h2 class="text-start company center2">Nom société</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Facture N° {{ $sale->id }}</span> <br>
                    <span>Date: {{ $sale->created_at->format('d/m/Y') }}</span> <br>
                    <span>Adresse: 14,chemin Mohamed Ali, Biskra</span> <br>
                    <span>Zip code : 16000</span> <br>
                    <span>Téléphone: 02323232323</span> <br>
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Détails de la commande</th>
                <th width="50%" colspan="2">Détails de client</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Commande N°:</td>
                <td>{{ $command->id }}</td>

                <td>Nom complet</td>
                <td>{{ $client->last_name }} {{ $client->first_name }}</td>
            </tr>
            <tr>
                <td>Date de commande:</td>
                <td>{{ $command->created_at->format('d/m/Y \à H:i') }}</td>

                <td>Email:</td>
                <td>{{ $client->email }}</td>
            </tr>
            <tr>
                <td>Méthode de paiement:</td>
                <td>{{ $command->payment_method }}</td>

                <td>Téléphone:</td>
                <td>{{ $client->phone_number }}</td>
            </tr>
            <tr>
                <td>Etat de la commande:</td>
                <td>Confirmé</td>

                <td>Adresse:</td>
                <td>{{ $client->address }}</td>
            </tr>
            <tr>
                <td colspan="2" class="w-left-bor w-bot-bor"></td>
                <td>Code fiscal</td>
                <td>{{ empty($client->code_fiscal) ? '...' : $client->code_fiscal }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Liste des produits
                </th>
            </tr>
            <tr class="bg-blue">
                <th>ID</th>
                <th>Produit</th>
                <th>PU HT</th>
                <th>Quantité</th>
                <th>Montant HT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productsWithQuantities as $productWithQuantity)
                <tr>
                    <td width="10%">{{ $loop->iteration }}</td>
                    <td>{{ $productWithQuantity['name'] }}</td>
                    <td width="15%">{{ $productWithQuantity['price_at_sale'] }}</td>
                    <td width="20%">{{ $productWithQuantity['quantity'] }}</td>
                    <td width="20%" class="fw-bold">
                        {{ $productWithQuantity['total_price'] }}</td>
                </tr>
            @endforeach
            <tr style="height: 20px;">
                <td colspan="3" class="w-left-bor w-bot-bor w-right-bor"></td>
                <td colspan="2" class="w-right-bor"></td>
            </tr>
            <tr>
                <td colspan="3" class="w-top-bor w-bot-bor w-left-bor "></td>
                <td colspan="1">DZD HT:</td>
                <td colspan="1">{{ $command->total_price }}</td>
            </tr>
            <tr>
                <td colspan="3" class=" w-top-bor w-bot-bor w-left-bor"></td>
                <td colspan="1">TVA 19%:</td>
                <td colspan="1">{{ $tva }}</td>
            </tr>
            @if ($command->payment_method == 'Espèce')
                <tr>
                    <td colspan="2" class="w-top-bor w-bot-bor w-left-bor w-right-bor"></td>
                    <td colspan="1" class="w-left-bor "></td>
                    <td colspan="1">Droit de timbre 1%:</td>
                    <td colspan="1">{{ $timbre }}</td>
                </tr>
            @endif
                <tr>
                    <td colspan="2" class="w-top-bor w-bot-bor w-left-bor"></td>
                    <td colspan="1" class="total-heading">TOTAL DZD</td>
                    <td colspan="1" class="total-heading">TTC</td>
                    <td colspan="1" class="total-heading">{{ $total }}</td>
                </tr>
        </tbody>
    </table>


</body>

</html>
