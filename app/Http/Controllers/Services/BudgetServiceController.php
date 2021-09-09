<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class BudgetServiceController extends Controller
{
   
    public function generatePdf(Request $request) {
        $this->budget = Budget::find($request->route('id'));
        $pdf = app('dompdf.wrapper');
		$date = date('d/m/Y', strtotime($this->budget->date));

		if ($this->budget->currency == "UYU") {
			$currency = trans('crud.budget.uyu');
		} else {
			$currency = $this->budget->currency;
		}

		$headings = '';
		$num = 0;
		foreach ($this->budget->headings_data as $data) {
			$num ++;
			$dec = 0;
			$heading_subtotal = 0;
			$heading_total = 0;
			$heading_tax = 0;
			
			$heading_body = '';
			foreach ($data['subheading'] as $subheadings) {

				$qty = (int) $subheadings['qty'];

				$heading_subtotal += $qty * (float)$subheadings['price'];
				$heading_total += $qty * (float)$subheadings['price'];
				$heading_tax += (float)$subheadings['tax'];

				$dec++;
				
				$price = number_format((float)$subheadings['price'], 2, ',', '.');
				$subtotal = number_format($qty * (float)$subheadings['price'], 2, ',', '.');
				$tax = number_format($qty * (float)$subheadings['tax'], 2, ',', '.');				

				$heading_body .= '
				<tr class="detail">
					<td class="number">'.$num.'.'.$dec.'</td>
					<td class="desc">'.$subheadings['description'].'</td>
					<td class="unidad">'.$subheadings['unit'].'</td>
					<td class="qty">'.$qty.'</td>
					<td class="total">'.$price.'</td>
					<td class="total">'.$subtotal.'</td>
					<td class="imponible">'.$tax.'</td>
				</tr>
				';
			}

			$heading_head = '
				<tr class="heading">
					<td class="center number">'.$num.'.0</td>
					<td colspan="4">'.$data['heading'].'</td>
					<td>'.number_format($heading_subtotal, 2, ',', '.').'</td>
					<td class="imponible">'.number_format($heading_tax, 2, ',', '.').'</td>
				</tr>';

			$headings .= $heading_head.$heading_body;
		}

		$conditions = '';
		foreach ($this->budget->conditions_data as $condition) {
			$conditions .= '<li>'.$condition['name'].': '.$condition['desc'].'</li>';
		}
		
		$notes = '';
		foreach ($this->budget->notes_data as $note) {
			$notes .= '<li>'.$note['note'].'</li>';
		}
		
		$teams = '';
		foreach ($this->budget->team_data as $team) {
			$teams .= '<li>'.$team['name'].': '.$team['desc'].'</li>';
		}

		$html = '
		<html>
			<head>
				<link rel="stylesheet" href="packages/backpack/base/css/budgetInvoice.css">
				<title>Cotización '.$this->budget->client->name.' (#'.$this->budget->id.')</title>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="description" content="Citrino arquitectos">
				<meta name="author" content="Citrino arquitectos">
				<meta name="template-hash" content="0c73fb5bcd04e18017faaf8a196dfea5">
			</head>
			<body>
				<header>
					<div class="header">
						<table>
							<tr>
								<td>
									<img width="280" src="'.asset('img/citrinoarquitectos.png').'">
								</td>
								<td>
									<div class="company-info">
										<div>Emilio Romero 137 BIS, MVD</div>
										<div>099 170 056 - 2308 54 94</div>
										<div>citrinoarquitectos.com</div>
										<div>presupuestos@citrinoarquitectos.com</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</header>
				<footer>
					<div class="company-info">
						<span>Emilio Romero 137 BIS, MVD</span>
						<span>099 170 056 - 2308 54 94</span>
						<br>
						<span>citrinoarquitectos.com - presupuestos@citrinoarquitectos.com</span>
					</div>
				</footer>
				<main>
					<p style="page-break-after: avoid;">
						<section id="invoice-title-number">
							<div class="title">Presupuesto</div>
							<div class="number">#'.$this->budget->id.'</div>
						</section>
						
						<table class="client-info">
							<tr>
								<td class="text">
									Objeto:
								</td>
								<td></td>
								<td></td>
								
							</tr>
							<tr>
								<td class="text">
									<b>'.$this->budget->title.'</b>
								</td>
								<td class="date" rowspan="2">Fecha '.$date.'</td>
								<td class="currency" rowspan="2">Moneda '.$this->budget->currency.'</td>
							</tr>
							<tr>
								<td class="text">
									Cliente:
								</td>
							</tr>
							<tr>
								<td class="text">
									<b>'.$this->budget->client->name.'</b>
								</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="text">
									<p>'.$this->budget->client->address.'</p>
									<p>'.$this->budget->client->email.'</p>
									<p>'.$this->budget->client->phone.'</p>
								</td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</p>
					<p style="page-break-after: never;">
						<section id="items">
							<div class="desc">
								<span>Tenemos el agrado de presentarles la siguiente propuesta de acuerdo a la visita de obra realizada al lugar.</span>
							</div>
							<table class="resume" cellpadding="0" cellspacing="0">
								<tr>
									<th class="number">Nº</th>
									<th class="desc">Descripción</th>
									<th class="unidad">Unidad</th>
									<th class="qty">Cant</th>
									<th class="total">Precio unitario</th>
									<th class="total">Subtotal</th>
									<th class="imponible">Monto Imponible (UYU)</th>
								</tr>
								'.$headings.'
								<tr class="total">
									<td class="number"></td>
									<td class="desc" colspan="4">Subtotal:</td>
									<td class="unidad1" colspan="2">'.$currency.number_format($this->budget->subtotal, 2, ',', '.').'</td>
								</tr>
								<tr class="total">
									<td class="number"></td>
									<td class="desc" colspan="4">IVA:</td>
									<td class="unidad1" colspan="2">'.$currency.number_format($this->budget->iva, 2, ',', '.').'</td>
								</tr>
								<tr class="total2">
									<td class="number border"></td>
									<td class="desc border" colspan="3">Total:</td>
									<td class="unidad1 border" colspan="2">'.$currency.number_format($this->budget->total, 2, ',', '.').'</td>
									<td class="unidad2 border">'.$currency.'300.800,00</td>
								</tr>
								<tr class="total2">
									<td class="number"></td>
									<td class="desc" colspan="4">LEYES SOCIALES (aprox. 73% del Monto imponible):</td>
									<td class="unidad1" colspan="2">'.trans('crud.budget.uyu').number_format($this->budget->social_laws_amount, 2, ',', '.').'</td>
								</tr>
							</table>  
						</section>
	
						<section id="terms">
							<span>Notas sobre lo presupuestado:</span>
							<ul>'.$notes.'</ul>
						</section>

						<section id="terms">
							<span>Condiciones Comerciales:</span>
							<ul>'.$conditions.'</ul>
						</section>

						<section id="terms">
							<span>Equipo técnico:</span>
							<ul>'.$teams.'</ul>
						</section>
			
					</p>
				</main>
			</body>
		</html>';
        
		$htm = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
		$pdf->loadHTML($htm);
		$name = "Presupuesto ".$this->budget->client->name." ".$this->budget->date.".pdf";
        return $pdf->download($name);

    }
}
