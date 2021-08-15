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
       
        $pdf->loadHTML('
        <html lang="en">
			<head>
				<link rel="stylesheet" href="packages/backpack/base/css/budgetInvoice.css">
				
				
				<meta charset="utf-8">
				<title>Unite (black-yellow)</title>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="description" content="Invoicebus Invoice Template">
				<meta name="author" content="Invoicebus">
				<meta name="template-hash" content="0c73fb5bcd04e18017faaf8a196dfea5">
			</head>
			<body>
				<div id="container">
					<section id="memo" style="display:block;">
						<div class="company-name ibcl_company_name" data-ibcl-id="company_name" >
							<span class="title1">CITRINO</span> 
							<br>
							<span class="title2">ARQUITECTOS</span>
						</div>
					
						<div class="payment-info">
							<div data-ibcl-id="payment_info1" class="ibcl_payment_info1" >Emilio Romero 137 BIS, MVD</div>
							<div data-ibcl-id="payment_info2" class="ibcl_payment_info2">099 170 056 - 2308 54 94</div>
							<div data-ibcl-id="payment_info3" class="ibcl_payment_info3">citrinoarquitectos.com</div>
							<div data-ibcl-id="payment_info4" class="ibcl_payment_info4">presupuestos@citrinoarquitectos.com</div>
						</div>

					</section>

					<section id="invoice-title-number">
						<span id="title" data-ibcl-id="invoice_title" class="ibcl_invoice_title" >Presupuesto</span>
						<span id="number" data-ibcl-id="invoice_number" class="ibcl_invoice_number" >#0037</span>
					</section>
					
					<div class="clearfix"></div>

					<section id="client-info">
						<span>Objeto:</span>
						<div>
							<span class="client-name ibcl_client_name">Acondicionamiento Sanitario / Obra Nueva</span>
						</div>
						<span class="ibcl_bill_to_label" >Cliente:</span>
						<div>
							<span class="client-name ibcl_client_name">Espacio Domótica</span>
						</div>
						<div>
							<span class="ibcl_client_address">Montevideo</span>
						</div>
						<div>
							<span class="ibcl_client_city_zip_state" >cliente@gmail.com</span>
						</div>
						<div>
							<span  class="ibcl_client_phone_fax">094875250</span>
						</div>
					</section>
					<div class="clearfix"></div>
					<section id="invoice-info">
						<div class="box-left">
							<div>
							<span data-ibcl-id="issue_date_label" class="ibcl_issue_date_label">Fecha</span>
							</div>
							
							<div>
							<span data-ibcl-id="issue_date" class="ibcl_issue_date">11/08/2021</span>
							</div>
						</div>
						<div class="box-right">
							<div>
							<span data-ibcl-id="currency_label" class="ibcl_currency_label" >Moneda</span>
							</div>
							<div>
							<span data-ibcl-id="currency" class="ibcl_currency" >USD</span>
							</div>
						</div>
					</section>
					
					<div class="clearfix"></div>
					
					<section id="items">
						<div class="desc">
							<span>Por la presente tenemos el agrado de presentar la siguiente propuesta economica en base a los recaudos suministrados: Memoria técnica de acondicionamiento sanitario y planos.</span>
						</div>
						<table cellpadding="0" cellspacing="0">
							<tbody>
							<tr>
								<th>Nº</th>
								<th>Descripción</th>
								<th>Unidad</th>
								<th>Cantidad</th>
								<th>P. unitario</th>
								<th>Subtotal</th>
								<th>Total</th>
							</tr>
							<tr class="heading">
								<td>1</td>
								<td colspan="6">Acondicionamiento Sanitario / Obra Nueva</td>
							</tr>
							<tr>
								<td>1.1</td>
								<td>Implantación y replanteo</td>
								<td>GL</td>
								<td>1</td>
								<td>1.200,00</td>
								<td>1.200,00</td>
								<td>1.200,00</td>
							</tr>
							<tr>
								<td>1.2</td>
								<td>Desagües de primaria PVC ∅ 110 (en planta, subterraneo, incluye construcción de Cámaras de Inspección)</td>
								<td>GL</td>
								<td>1</td>
								<td>3.740,00</td>
								<td>3.740,00</td>
								<td>3.740,00</td>
							</tr>
							<tr>
								<td>1.3</td>
								<td>Desagües de primaria PVC ∅ 110 (columnas)</td>
								<td>GL</td>
								<td>1</td>
								<td>300,00</td>
								<td>300,00</td>
								<td>300,00</td>
							</tr>
							<tr>
								<td>1.4</td>
								<td>Desagües de secundaria PVC ∅ 110, ∅ 50 y ∅ 40</td>
								<td>GL</td>
								<td>1</td>
								<td>1.473,00</td>
								<td>1.473,00</td>
								<td>1.473,00</td>
							</tr>
							<tr>
								<td>1.5</td>
								<td>Desagües de pluviales PVC ∅ 160 y ∅ 110 (en planta, subterráneo)</td>
								<td>GL</td>
								<td>1</td>
								<td>5.730,00</td>
								<td>5.730,00</td>
								<td>5.730,00</td>
							</tr>
							<tr>
								<td>1.6</td>
								<td>Desagües de pluviales PVC ∅ 160 y ∅ 110 (en planta, subterraneo)</td>
								<td>GL</td>
								<td>1</td>
								<td>2.545,00</td>
								<td>2.545,00</td>
								<td>2.545,00</td>
							</tr>
							<tr>
								<td>1.7</td>
								<td>Ventilaciones del acondicionamiento sanitario ∅ 110 y ∅ 50</td>
								<td>GL</td>
								<td>1</td>
								<td>1.800,00</td>
								<td>1.800,00</td>
								<td>1.800,00</td>
							</tr>
							<tr>
								<td>1.8</td>
								<td>Abastecimiento de Agua Fria hacia el edificio ∅ 50 (desde el contador de OSE hacia cada servicio cocina y baños).</td>
								<td>GL</td>
								<td>1</td>
								<td>1.600,00</td>
								<td>1.600,00</td>
								<td>1.600,00</td>
							</tr>
							<tr>
								<td>1.9</td>
								<td>Abastecimiento y desagües de baños y cocina (ABAST. de Agua Fria ∅ 40mm, ∅ 32mm - Agua Caliente ∅ 25mm / DESAGÜES ∅ 110 y ∅63)</td>
								<td>GL</td>
								<td>1</td>
								<td>8.200,00</td>
								<td>8.200,00</td>
								<td>8.200,00</td>
							</tr>
							<tr>
								<td>1.10</td>
								<td>Pruebas manometricas e hidraulicas</td>
								<td>GL</td>
								<td>1</td>
								<td>800,00</td>
								<td>800,00</td>
								<td>800,00</td>
							</tr>
							<tr>
								<td>1.11</td>
								<td>Instalación de aparatos sanitarios (losa sanitaria, grifería y accesorios)</td>
								<td>GL</td>
								<td>1</td>
								<td>1.680,00</td>
								<td>1.680,00</td>
								<td>1.680,00</td>
							</tr>
							<tr>
								<td>1.12</td>
								<td>Movimientos de tierra para desagües y abastecimiento. Excavaciones, zanjeos y tapadas.</td>
								<td>GL</td>
								<td>1</td>
								<td>3.100,00</td>
								<td>3.100,00</td>
								<td>3.100,00</td>
							</tr>
							</tbody>
						</table>  
					</section>
					
					<section id="sums">
						<table cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<th>Subtotal:</th>
									<td>USD 32.168,00</td>
								</tr>
								
								<tr>
									<th>IVA:</th>
									<td>USD 7.076,96</td>
								</tr>
								
								<tr>
									<th>LEYES SOCIALES (aprox. 73% del Monto imponible):</th>
									<td>$ 210.560,00</td>
								</tr>
								
								<tr>
									<th>Total:</th>
									<td>USD 39.244,96</td>
								</tr>	
							</tbody>
						</table>
						<div class="clearfix"></div>
						<div class="total-stripe"></div>
					</section>
					
					<div class="clearfix"></div>
					
					<section id="terms">
						<span class="ibcl_terms_label">Notas sobre lo presupuestado:</span>
						<ul class="terms">
							<li>Los rubros consideran materiales y mano de obra. Se cotizaron productos de la calidad solicitada, nuevos y certificados.</li>
							<li>Se incluyen en los rubros correspondientes el suministro de Bocas de Desagüe; Piletas de Patio; Rejillas de Piso, Cajas Sifonadas, Camaras de</li>
							<li>NO SE COTIZÓ: aparatos - losa sanitaria, griferias, sifones cromados, rejas cromadas. Tampoco tramites, elaboración de planos o firma técnica.</li>
							<li>NO SE COTIZÓ la construcción de la cámara séptica de hormigón armado.</li>
							<li>Cotización por instalacion en PVC del sistema aerobico y anaerobico de la cámara séptica = USD 650 + IVA dólares americanos</li>
							<li>LEYES SOCIALES (aprox. 73% del Monto imponible) $ 210.560,00</li>
						</ul>
					</section>
					
					<section id="terms">
						<span class="ibcl_terms_label">Condiciones Comerciales:</span>
						<ul class="terms">
							<li>Plazo de ejecución: según el progreso de obra.</li>
							<li>Garantía sobre los trabajos: 2 años tras recepción final de obra.</li>
							<li>Forma de pago: Acopio del 35%, saldo por avance de obra.</li>
							<li>Mantenimiento de oferta: 90 días calendario.</li>
						</ul>
					</section>

					<div class="company-info">
						<span>Emilio Romero 137 BIS, MVD</span>
						<span>099 170 056 - 2308 54 94</span>
						<br>
						<span>citrinoarquitectos.com - presupuestos@citrinoarquitectos.com</span>
					</div>
				</div>
			</body>
		</html>');
        return $pdf->download('mi-archivo.pdf');

    }
}
