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
        $svg .= "<text x='".($svgWidth/2)."' y='".($svgHeight-10)."' text-anchor='middle'>Impact (1-5)</text>";
        $svg .= "<text x='20' y='".($svgHeight/2)."' transform='rotate(-90 20,".($svgHeight/2).")' text-anchor='middle'>Likelihood (1-5)</text>";
    
        // Color Zones
        $riskColors = [
            'Low Risk' => 'rgba(0, 255, 0, 0.3)',
            'Medium-Low Risk' => 'rgba(255, 255, 0, 0.3)',
            'Medium-High Risk' => 'rgba(255, 165, 0, 0.3)',
            'High Risk' => 'rgba(255, 0, 0, 0.3)'
        ];
    
        $riskZones = [
            'Low Risk' => ['x1' => 1, 'x2' => 2, 'y1' => 1, 'y2' => 2],
            'Medium-Low Risk' => ['x1' => 2, 'x2' => 4, 'y1' => 1, 'y2' => 3],
            'Medium-High Risk' => ['x1' => 4, 'x2' => 5, 'y1' => 3, 'y2' => 5],
            'High Risk' => ['x1' => 5, 'x2' => 5, 'y1' => 5, 'y2' => 5]
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
                $x = $padding + (($risk['imp_inh'] - 1) * $cellSize) + ($cellSize/2);
                $y = $padding + (($risk['hood_inh'] - 1) * $cellSize) + ($cellSize/2);
    
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