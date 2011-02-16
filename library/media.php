<?php

class Media {

    public $elements = array();
    public $gallery = array();
    public $max_width = 600;
    public $factor = 5;
    public $element_width;
    public $spacer = 3;
    

    public function parse() {
        $this->element_width = $this->max_width / $this->factor;
        if(!is_array($this->elements[0])) {
            for($i = 0; $i < count($this->elements); $i++) {
                list($w, $h) = getimagesize($this->elements[$i]);
                $this->elements[$i] = array($this->elements[$i], $w, $h);
            }
        }
        for($i = 0; $i < count($this->elements); $i++) {
            $this->elements[$i] = array($this->elements[$i][0], $this->elements[$i][1], $this->elements[$i][2], round(($this->element_width/$this->elements[$i][2])*$this->elements[$i][1]), $this->element_width);
        }
    }

    public function gallery($layout) {
        switch($layout) {
            case "justified":
                $row = 0;
                $row_elements = array();
                for($j = 0; $j <= count($this->elements); $j++) {
                    if($j < count($this->elements)) {
                        $row += $this->elements[$j][3];
                        $row_elements[] = $this->elements[$j];
                    }
                    if($row > $this->max_width - max(0, ((count($row_elements) - 2) * $this->spacer)) || $j == count($this->elements)) {
                        $row_num_elements = count($row_elements);
                        $maxw = $this->max_width - max(0, (($row_num_elements - 2) * $this->spacer));
                        $gal_row = array();
                        if($row_num_elements > 1) {
                            if($j != count($this->elements)) {
                                $hold = array_pop($row_elements);
                                $row_num_elements = count($row_elements);
                            } else {
                                $maxw = $this->max_width - max(0, (($row_num_elements - 1) * $this->spacer));
                            }
                            $orow = 0;
                            $htot = 0;
                            foreach($row_elements as $img) {
                                $orow += $img[3];
                            }
                            $extra = floor(($maxw - $orow) / $row_num_elements);
                            foreach($row_elements as $img) {
                                $htot += ($this->element_width / $img[3]) *  ($img[3] + $extra);
                            }
                            $h = $htot / count($row_elements);
                        } else {
                            $row_elements[0][3] = $this->max_width;
                            $row_elements[0][4] = ($row_elements[0][2] / $row_elements[0][1]) * $this->max_width;
                            $extra = 0;
                            $h = $row_elements[0][4];
                        }
                        for($p = 0; $p < $row_num_elements; $p++) {
                            if($maxw - ($orow + ($extra * $row_num_elements)) != 0 && $p == 0 && $row_num_elements != 1) {
                                $w = $row_elements[$p][3] + $extra + ($maxw - ($orow + ($extra * $row_num_elements)));
                            } else {
                                $w = $row_elements[$p][3] + $extra;
                            }
                            $gal_row[] = array($row_elements[$p][0], $w, $h);
                        }
                        $row_elements = array($hold);
                        if($j < count($this->elements)) {
                            $row = $this->elements[$j][3];
                        }
                        $this->gallery[] = $gal_row;
                    }
                }
                break;
            case "main":
                break;
            case "equal":
            default:
                break;
        }
    }
}

?>