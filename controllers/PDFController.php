<?php
require_once 'core/Controller.php';
require_once 'models/PrestamosPDF.php';
use Mpdf\Mpdf;
class PDFController extends Controller
{
    public function pdfreport()
    {
        $model = new PrestamoModel();
        $prestamos = $model->obtenerPrestamosDetallados();

        $html = "<h1 style='text-align:center;'>Reporte de Préstamos</h1>";
        $html .= "<table border='1' cellpadding='6' cellspacing='0' width='100%'>
                    <thead style='background-color:#f2f2f2;'>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Nº Serie</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Devolución</th>
                            <th>Fecha Entregado</th>
                            <th>¿Devuelto?</th>
                        </tr>
                    </thead><tbody>";

        foreach ($prestamos as $p) {
            $html .= "<tr>
                        <td>{$p['id_prestamo']}</td>
                        <td>{$p['usuario']}</td>
                        <td>{$p['numero_serie']}</td>
                        <td>{$p['fecha_prestamo']}</td>
                        <td>{$p['fecha_devolucion']}</td>
                        <td>{$p['fecha_entregado']}</td>
                        <td>" . ($p['devuelto'] ? 'Sí' : 'No') . "</td>
                    </tr>";
        }

        $html .= "</tbody></table>";

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output("reporte_prestamos_detallado.pdf", "I");
    }
}
