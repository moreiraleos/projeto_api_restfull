<?php

namespace Classes;

require_once "../vendor/autoload.php";

class Items
{
	private $itemsTable = "items";
	public $id;
	public $name;
	public $description;
	public $price;
	public $category_id;
	public $created;
	public $modified;
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function read()
	{
		if ($this->id) {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->itemsTable . " WHERE id = ?");
			$stmt->bind_param("i", $this->id);
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->itemsTable);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function create()
	{

		$stmt = $this->conn->prepare("
			INSERT INTO " . $this->itemsTable . "(`name`, `description`, `price`, `category_id`)
			VALUES(?,?,?,?)");

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));

		$stmt->bind_param("ssii", $this->name, $this->description, $this->price, $this->category_id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function update()
	{

		$stmt = $this->conn->prepare("
			UPDATE " . $this->itemsTable . " 
			SET name= ?, description = ?, price = ?, category_id = ?
			WHERE id = ?");

		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));

		$stmt->bind_param("ssiii", $this->name, $this->description, $this->price, $this->category_id, $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function delete()
	{

		$stmt = $this->conn->prepare("
			DELETE FROM " . $this->itemsTable . " 
			WHERE id = ?");

		$this->id = htmlspecialchars(strip_tags($this->id));

		$stmt->bind_param("i", $this->id);
		$stmt->execute();
		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
