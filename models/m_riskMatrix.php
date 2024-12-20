<?php
class RiskMap {
    private $connection;
    private $matrixData = [];

    public function __construct($conn) {
        $this->connection = $conn;
    }

    // mengkategorikan impact
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
    public function generateRiskMap() {
        $sql = "SELECT 
                    id_risk, 
                    kode_risk, 
                    hood_inh, 
                    imp_inh,
                    hood_res,
                    imp_res,
                    hood_mit,
                    imp_mit,
                    (hood_inh * imp_inh) as risk_score_inh,
                    (hood_res * imp_res) as risk_score_res,
                    (hood_mit * imp_mit) as risk_score_mit
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

    // membuat visualisasi html dari risk map
    public function renderRiskMapVisualization() {
        if (empty($this->matrixData)) {
            $this->generateRiskMap();
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

    public function generateCartesianRiskMap() {
        if (empty($this->matrixData)) {
            $this->generateRiskMap();
        }
        
        $svgWidth = 500;
        $svgHeight = 500;
        $padding = 60;
        $gridSize = $svgWidth - (2 * $padding);
        $cellSize = $gridSize / 5;
    
        $pointPositions = [
            'inherent' => [],
            'residual' => [],
            'mitigated' => []
        ];

        foreach ($this->matrixData as $category => $risks) {
            foreach ($risks as $risk) {
                // Inherent Risk Points
                $keyInh = $risk['hood_inh'] . '-' . $risk['imp_inh'];
                if (!isset($pointPositions['inherent'][$keyInh])) {
                    $pointPositions['inherent'][$keyInh] = [];
                }
                $pointPositions['inherent'][$keyInh][] = [
                    'kode_risk' => $risk['kode_risk'],
                    'category' => $category,
                    'hood' => $risk['hood_inh'],
                    'imp' => $risk['imp_inh']
                ];

                // Residual Risk Points
                $keyRes = $risk['hood_res'] . '-' . $risk['imp_res'];
                if (!isset($pointPositions['residual'][$keyRes])) {
                    $pointPositions['residual'][$keyRes] = [];
                }
                $pointPositions['residual'][$keyRes][] = [
                    'kode_risk' => $risk['kode_risk'],
                    'category' => $this->categorizeRisk($risk['hood_res'], $risk['imp_res']),
                    'hood' => $risk['hood_res'],
                    'imp' => $risk['imp_res']
                ];

                // Mitigated Risk Points
                $keyMit = $risk['hood_mit'] . '-' . $risk['imp_mit'];
                if (!isset($pointPositions['mitigated'][$keyMit])) {
                    $pointPositions['mitigated'][$keyMit] = [];
                }
                $pointPositions['mitigated'][$keyMit][] = [
                    'kode_risk' => $risk['kode_risk'],
                    'category' => $this->categorizeRisk($risk['hood_mit'], $risk['imp_mit']),
                    'hood' => $risk['hood_mit'],
                    'imp' => $risk['imp_mit']
                ];
            }
        }

        // Start SVG
        $svg = "<svg width='$svgWidth' height='$svgHeight' xmlns='http://www.w3.org/2000/svg'>";

        // Style definitions
        $svg .= "<defs>
            <style>
                .risk-point { cursor: pointer; }
                .risk-point-info { 
                    opacity: 0; 
                    pointer-events: none;
                    transition: opacity 0.3s ease;
                }
                .risk-point.active .risk-point-info { 
                    opacity: 1;
                    pointer-events: all;
                }
                .risk-code { 
                    font-size: 8px; 
                    fill: white; 
                    pointer-events: none;
                }
            </style>
        </defs>";
         
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
    

        // Plot Risks dengan modifikasi untuk menampilkan kode di dalam titik
        foreach (['inherent', 'residual', 'mitigated'] as $riskType) {
            foreach ($pointPositions[$riskType] as $position => $risks) {
                list($hood, $imp) = explode('-', $position);
                $x = $padding + (($hood - 1) * $cellSize) + ($cellSize/2);
                $y = $padding + (($imp - 1) * $cellSize) + ($cellSize/2);
                
                if (count($risks) === 1) {
                    $risk = $risks[0];
                    $svg .= $this->createRiskPoint($x, $y, $risk, false, $riskType);
                } else {
                    $offset = 0;
                    foreach ($risks as $index => $risk) {
                        $offsetX = $x + cos($offset) * 5;
                        $offsetY = $y + sin($offset) * 5;
                        $svg .= $this->createRiskPoint($offsetX, $offsetY, $risk, true, $riskType);
                        $offset += (2 * M_PI) / count($risks);
                    }
                }
            }
        }
    
        $svg .= "</svg>";
        return $svg;
    }

    private function createRiskPoint($x, $y, $risk, $isStacked, $riskType) {
        $pointId = 'point_' . $risk['kode_risk'] . '_' . $riskType;
        // Define colors for different risk types
        $colors = [
            'inherent' => 'blue',
            'residual' => 'orange',
            'mitigated' => 'red'
        ];
        
        if ($isStacked) {
            $radius = 15;
            $angle = rand(0, 360);
            $x += cos(deg2rad($angle)) * $radius;
            $y += sin(deg2rad($angle)) * $radius;
        }
        
        $svg = "<g class='risk-point' id='$pointId' onclick='toggleRiskPoint(this)'>";
        
        // Drop shadow
        $svg .= "<defs>
            <filter id='shadow_$pointId' x='-20%' y='-20%' width='140%' height='140%'>
                <feGaussianBlur in='SourceAlpha' stdDeviation='2' />
                <feOffset dx='1' dy='1' />
                <feComponentTransfer>
                    <feFuncA type='linear' slope='0.3'/>
                </feComponentTransfer>
                <feMerge>
                    <feMergeNode />
                    <feMergeNode in='SourceGraphic'/>
                </feMerge>
            </filter>
        </defs>";
        
        // Background circle
        $svg .= "<circle cx='$x' cy='$y' r='12' fill='white' stroke='#666' 
                 stroke-width='1' filter='url(#shadow_$pointId)'/>";
        
        // Main circle with color based on risk type
        $svg .= "<circle cx='$x' cy='$y' r='10' fill='{$colors[$riskType]}'/>";
        
        // Risk code text
        $svg .= "<text x='$x' y='$y' 
                 text-anchor='middle' 
                 dominant-baseline='middle' 
                 class='risk-code'>" . 
                 htmlspecialchars($risk['kode_risk']) . 
                 "</text>";
        
        // Tooltip positioning
        $tooltipX = $x + 15;
        $tooltipY = $y - 30;
        
        if ($x > 400) $tooltipX = $x - 135;
        if ($y > 400) $tooltipY = $y - 90;
        
        // Tooltip content
        $riskTypeLabel = ucfirst($riskType);
        $svg .= "<g class='risk-point-info'>
            <rect x='$tooltipX' y='$tooltipY' 
                  width='150' height='75' 
                  fill='white'
                  stroke='#666'
                  stroke-width='1'
                  rx='4' ry='4'
                  filter='url(#shadow_$pointId)'/>
            <text x='".($tooltipX+5)."' y='".($tooltipY+15)."' 
                  fill='#333' font-size='10px'>
                <tspan x='".($tooltipX+5)."' dy='0'>Kode: {$risk['kode_risk']}</tspan>
                <tspan x='".($tooltipX+5)."' dy='12'>$riskTypeLabel Risk</tspan>
                <tspan x='".($tooltipX+5)."' dy='12'>Likelihood: {$risk['hood']}</tspan>
                <tspan x='".($tooltipX+5)."' dy='12'>Impact: {$risk['imp']}</tspan>
                <tspan x='".($tooltipX+5)."' dy='12'>Category: {$risk['category']}</tspan>
            </text>
        </g>";
        
        $svg .= "</g>";
        return $svg;
    }
}