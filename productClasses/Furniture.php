<?php
class Furniture extends MProductList {
	protected $sku;
	protected $name;
	protected $price;
	protected $size;
	protected $height;
	protected $width;
	protected $weight;
	protected $length;

	public function setValues($sku, $name, $price, $size, $height, $width, $length, $weight) {
		$this->sku = $sku;
		$this->name = $name;
		$this->price = $price;
		$this->size = $size;
		$this->height = $height;
		$this->width = $width;
		$this->weight = $weight;
		$this->length = $length;
	}

	public function getInfo() {
		$html = '<div class="card-box-order-mine p-2 bd-highlight">';
		$html .= '<input class="delete-checkbox" type="checkbox" name="delete[]" value="' . $this->sku . '">';
		$html .= '<p>' . $this->sku . '</p>';
		$html .= '<p>' . $this->name . '</p>';
		$html .= '<p>' . $this->price . '.00 $</p>';
		$html .= '<p>Dimension: ';

		$dimensions = array();

		if ($this->size && $this->size !== 'Furniture') {
			$dimensions[] = $this->size;
		}

		if ($this->height) {
			$dimensions[] = $this->height;
		}

		if ($this->width) {
			$dimensions[] = $this->width;
		}

		if ($this->length) {
			$dimensions[] = $this->length;
		}

		$html .= implode(' x ', $dimensions);

		$html .= '</p>';
		$html .= '</div>';

		return $html;
	}

}
?>
