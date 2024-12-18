<?php
class RiskMatrix {
    private $connection;
    private $matrixData = [];

    public function __construct($conn) {
        $this->connection = $conn;
    }

    // Categorize risk based on likelihood and impact
    private function categorizeRisk($likelihood, $impact) {
        $riskScore = $likelihood * $impact;
        
        if ($riskScore <= 4) {
            return 'Low Risk';
        } elseif ($riskScore <= 9) {
            return 'Medium-Low Risk';
        } elseif ($riskScore <= 15) {
            return 'Medium-High Risk';
        } else {
            return 'High Risk';
        }
    }

    // Fetch and process risk data
    public function generateRiskMatrix() {
        $sql = "SELECT 
                    id_risk, 
                    kode_risk, 
                    hood_inh, 
                    imp_inh, 
                    (hood_inh * imp_inh) as risk_score 
                FROM tb_risk";
        
        $result = $this->connection->query($sql);
        
        $matrix = [
            'Low Risk' => [],
            'Medium-Low Risk' => [],
            'Medium-High Risk' => [],
            'High Risk' => []
        ];

        while ($row = $result->fetch_assoc()) {
            $riskCategory = $this->categorizeRisk($row['hood_inh'], $row['imp_inh']);
            $matrix[$riskCategory][] = $row;
        }

        $this->matrixData = $matrix;
        return $matrix;
    }

    // Generate HTML visualization of risk matrix
    public function renderRiskMatrixVisualization() {
        if (empty($this->matrixData)) {
            $this->generateRiskMatrix();
        }

        $html = '<div class="risk-matrix">';
        $html .= '<h2>Risk Matrix Visualization</h2>';
        
        foreach ($this->matrixData as $category => $risks) {
            $html .= "<h3>$category</h3>";
            if (!empty($risks)) {
                $html .= '<ul>';
                foreach ($risks as $risk) {
                    $html .= sprintf(
                        '<li>Kode: %s, Likelihood: %d, Impact: %d</li>', 
                        $risk['kode_risk'], 
                        $risk['hood_inh'], 
                        $risk['imp_inh']
                    );
                }
                $html .= '</ul>';
            } else {
                $html .= '<p>No risks in this category</p>';
            }
        }
        
        $html .= '</div>';
        return $html;
    }

    // Export risk matrix data to JSON for potential frontend visualization
    public function exportRiskMatrixToJSON() {
        if (empty($this->matrixData)) {
            $this->generateRiskMatrix();
        }
        
        return json_encode($this->matrixData);
    }

    public function generateCartesianRiskMatrix() {
        // Fetch risk data again if not already loaded
        if (empty($this->matrixData)) {
            $this->generateRiskMatrix();
        }
    
        // SVG Configuration
        $svgWidth = 500;
        $svgHeight = 500;
        $padding = 60;
        $gridSize = $svgWidth - (2 * $padding);
        $cellSize = $gridSize / 5;
    
        // Start SVG
        $svg = "<svg width='$svgWidth' height='$svgHeight' xmlns='http://www.w3.org/2000/svg'>";
    
        // Background Grid
        $svg .= "<rect x='$padding' y='$padding' width='$gridSize' height='$gridSize' fill='#f0f0f0' stroke='#cccccc' />";
    
        // Draw Grid Lines
        for ($i = 0; $i <= 5; $i++) {
            $x = $padding + ($i * $cellSize);
            $svg .= "<line x1='$x' y1='$padding' x2='$x' y2='".($svgHeight - $padding)."' stroke='#aaaaaa' stroke-dasharray='5,5' />";
    
            $y = $padding + ($i * $cellSize);
            $svg .= "<line x1='$padding' y1='$y' x2='".($svgWidth - $padding)."' y2='$y' stroke='#aaaaaa' stroke-dasharray='5,5' />";
        }
    
        // Axis Labels
        $svg .= "<text x='".($svgWidth/2)."' y='".($svgHeight-10)."' text-anchor='middle'>Likelihood (1-5)</text>";
        $svg .= "<text x='20' y='".($svgHeight/2)."' transform='rotate(-90 20,".($svgHeight/2).")' text-anchor='middle'>Impact (1-5)</text>";
    
        // Color Zones
        $riskColors = [
            'LOW-1' => 'rgba(9, 176, 9, 0.71)',
            'LOW-2' => 'rgba(9, 176, 9, 0.71)',
            'LOW-3' => 'rgba(9, 176, 9, 0.71)',
            'LOW-4' => 'rgba(9, 176, 9, 0.71)',
            'LOW-5' => 'rgba(9, 176, 9, 0.71)',
            'LOW-6' => 'rgba(9, 176, 9, 0.71)',
            'LOW-7' => 'rgba(9, 176, 9, 0.71)',
            'LOW-8' => 'rgba(9, 176, 9, 0.71)',
            'MNOR-1' => 'rgba(190, 196, 11, 0.71)',
            'MNOR-2' => 'rgba(190, 196, 11, 0.71)',
            'MNOR-3' => 'rgba(190, 196, 11, 0.71)',
            'MNOR-4' => 'rgba(190, 196, 11, 0.71)',
            'MNOR-5' => 'rgba(190, 196, 11, 0.71)',
            'MED-1' => 'rgba(255, 165, 0, 0.3)',
            'MED-2' => 'rgba(255, 165, 0, 0.3)',
            'MED-3' => 'rgba(255, 165, 0, 0.3)',
            'MED-4' => 'rgba(255, 165, 0, 0.3)',
            'MED-5' => 'rgba(255, 165, 0, 0.3)',
            'MED-6' => 'rgba(255, 165, 0, 0.3)',
            'MED-7' => 'rgba(255, 165, 0, 0.3)',
            'MED-8' => 'rgba(255, 165, 0, 0.3)',
            'HIGH-1' => 'rgba(255, 0, 0, 0.3)',
            'HIGH-2' => 'rgba(255, 0, 0, 0.3)',
            'HIGH-3' => 'rgba(255, 0, 0, 0.3)',
            'HIGH-4' => 'rgba(255, 0, 0, 0.3)'
        ];
    
        $riskZones = [
            'LOW-1' => ['x1' => 1, 'x2' => 2, 'y1' => 1, 'y2' => 2],
            'LOW-2' => ['x1' => 2, 'x2' => 3, 'y1' => 1, 'y2' => 2],
            'LOW-3' => ['x1' => 3, 'x2' => 4, 'y1' => 1, 'y2' => 2],
            'LOW-4' => ['x1' => 4, 'x2' => 5, 'y1' => 1, 'y2' => 2],
            'LOW-5' => ['x1' => 2, 'x2' => 3, 'y1' => 2, 'y2' => 3],
            'LOW-6' => ['x1' => 1, 'x2' => 2, 'y1' => 2, 'y2' => 3],
            'LOW-7' => ['x1' => 1, 'x2' => 2, 'y1' => 3, 'y2' => 4],
            'LOW-8' => ['x1' => 1, 'x2' => 2, 'y1' => 4, 'y2' => 5],

            'MNOR-1' => ['x1' => 2, 'x2' => 3, 'y1' => 4, 'y2' => 5],
            'MNOR-2' => ['x1' => 2, 'x2' => 3, 'y1' => 3, 'y2' => 4],
            'MNOR-3' => ['x1' => 3, 'x2' => 4, 'y1' => 3, 'y2' => 4],
            'MNOR-4' => ['x1' => 3, 'x2' => 4, 'y1' => 2, 'y2' => 3],
            'MNOR-5' => ['x1' => 4, 'x2' => 5, 'y1' => 2, 'y2' => 3],
            'MED-1' => ['x1' => 5, 'x2' => 6, 'y1' => 1, 'y2' => 2],
            'MED-2' => ['x1' => 5, 'x2' => 6, 'y1' => 2, 'y2' => 3],
            'MED-3' => ['x1' => 5, 'x2' => 6, 'y1' => 3, 'y2' => 4],
            'MED-4' => ['x1' => 4, 'x2' => 5, 'y1' => 3, 'y2' => 4],
            'MED-5' => ['x1' => 3, 'x2' => 4, 'y1' => 4, 'y2' => 5],
            'MED-6' => ['x1' => 3, 'x2' => 4, 'y1' => 5, 'y2' => 6],
            'MED-7' => ['x1' => 1, 'x2' => 2, 'y1' => 5, 'y2' => 6],
            'MED-8' => ['x1' => 2, 'x2' => 3, 'y1' => 5, 'y2' => 6],
            'HIGH-1' => ['x1' => 4, 'x2' => 5, 'y1' => 4, 'y2' => 5],
            'HIGH-2' => ['x1' => 5, 'x2' => 6, 'y1' => 5, 'y2' => 6],
            'HIGH-3' => ['x1' => 4, 'x2' => 5, 'y1' => 5, 'y2' => 6],
            'HIGH-4' => ['x1' => 5, 'x2' => 6, 'y1' => 4, 'y2' => 5]
        ];
    
        // Draw Risk Zones
        foreach ($riskZones as $category => $zone) {
            $x = $padding + (($zone['x1'] - 1) * $cellSize);
            $y = $padding + (($zone['y1'] - 1) * $cellSize);
            $width = ($zone['x2'] - $zone['x1']) * $cellSize;
            $height = ($zone['y2'] - $zone['y1']) * $cellSize;
    
            $svg .= "<rect x='$x' y='$y' width='$width' height='$height' fill='{$riskColors[$category]}' />";
            $svg .= "<text x='".($x + $width/2)."' y='".($y + $height/2)."' text-anchor='middle' fill='black'>$category</text>";
        }
    
        // Plot Risks
        foreach ($this->matrixData as $category => $risks) {
            foreach ($risks as $risk) {
                $x = $padding + (($risk['hood_inh'] - 1) * $cellSize) + ($cellSize/2);
                $y = $padding + (($risk['imp_inh'] - 1) * $cellSize) + ($cellSize/2);
    
                $svg .= "<g class='risk-point'>";
                $svg .= "<circle cx='$x' cy='$y' r='5' fill='blue' />";
                $svg .= "<text x='".($x+10)."' y='".($y+10)."' class='risk-point-label' font-size='10'>".htmlspecialchars($risk['kode_risk'])."</text>";
                $svg .= "<text x='".($x+20)."' y='".($y+20)."' class='risk-point-info'>
                            Kode: ".htmlspecialchars($risk['kode_risk'])."
                            Likelihood: {$risk['hood_inh']}
                            Impact: {$risk['imp_inh']}
                            Risk Category: $category
                        </text>";
                $svg .= "</g>";
            }
        }
    
        $svg .= "</svg>";
        return $svg;
    }
}