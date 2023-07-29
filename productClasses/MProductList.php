<?php

abstract class MProductList {
	protected $sku;
	protected $name;
	protected $price;
	protected $size;
	protected $height;
	protected $width;
	protected $length;
	protected $weight;

	abstract public function setValues($sku, $name, $price, $size, $height, $width, $length, $weight);
	abstract public function getInfo();

	public function getSKU() {
		return $this->sku;
	}

	public function getName() {
		return $this->name;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getSize() {
		return $this->size;
	}

	public function getHeight() {
		return $this->height;
	}

	public function getWidth() {
		return $this->width;
	}

	public function getLength() {
		return $this->length;
	}

	public function getWeight() {
		return $this->weight;
	}
}

?>
