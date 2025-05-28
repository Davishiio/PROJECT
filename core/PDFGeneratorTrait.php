<?php
namespace Core;

require_once __DIR__ . '/../vendor/autoload.php';
use Mpdf\Mpdf;



trait PDFGeneratorTrait
{
    public function generarPDFBase($modeloClass, $titulo)
    {
        $modelo = new $modeloClass();
        $data = $modelo->all();

        if (!$data || empty($data)) {
            http_response_code(404);
            echo json_encode(['error' => 'No hay datos para mostrar']);
            return;
        }

        $mpdf = new Mpdf();
        $html = "<h1>$titulo</h1><table border='1' width='100%' style='border-collapse: collapse;'>";

        $keys = array_keys($data[0]);
        echo($keys); // Para depurar y ver las claves del primer elemento
        $html .= "<thead><tr>";
        foreach ($keys as $key) {
            $html .= "<th>" . ucfirst($key) . "</th>";
        }
        $html .= "</tr></thead><tbody>";

        foreach ($data as $row) {
            $html .= "<tr>";
            foreach ($row as $value) {
                $html .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $html .= "</tr>";
        }

        $html .= "</tbody></table>";
        $mpdf->WriteHTML($html);
        $mpdf->Output("reporte.pdf", 'I');
    }
}
