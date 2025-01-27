<?php

declare(strict_types=1);

namespace Files\Model;

use Files\Api;
use Files\Logger;

require_once __DIR__ . '/../Files.php';

/**
 * Class Payment
 *
 * @package Files
 */
class Payment {
  private $attributes = [];
  private $options = [];

  function __construct($attributes = [], $options = []) {
    foreach ($attributes as $key => $value) {
      $this->attributes[str_replace('?', '', $key)] = $value;
    }

    $this->options = $options;
  }

  public function __set($name, $value) {
    $this->attributes[$name] = $value;
  }

  public function __get($name) {
    return @$this->attributes[$name];
  }

  public function isLoaded() {
    return !!@$this->attributes['id'];
  }

  // int64 # Line item Id
  public function getId() {
    return @$this->attributes['id'];
  }

  // double # Line item amount
  public function getAmount() {
    return @$this->attributes['amount'];
  }

  // double # Line item balance
  public function getBalance() {
    return @$this->attributes['balance'];
  }

  // date-time # Line item created at
  public function getCreatedAt() {
    return @$this->attributes['created_at'];
  }

  // string # Line item currency
  public function getCurrency() {
    return @$this->attributes['currency'];
  }

  // string # Line item download uri
  public function getDownloadUri() {
    return @$this->attributes['download_uri'];
  }

  // InvoiceLineItem # Associated invoice line items
  public function getInvoiceLineItems() {
    return @$this->attributes['invoice_line_items'];
  }

  // string # Line item payment method
  public function getMethod() {
    return @$this->attributes['method'];
  }

  // PaymentLineItem # Associated payment line items
  public function getPaymentLineItems() {
    return @$this->attributes['payment_line_items'];
  }

  // date-time # Date/time payment was reversed if applicable
  public function getPaymentReversedAt() {
    return @$this->attributes['payment_reversed_at'];
  }

  // string # Type of payment if applicable
  public function getPaymentType() {
    return @$this->attributes['payment_type'];
  }

  // string # Site name this line item is for
  public function getSiteName() {
    return @$this->attributes['site_name'];
  }

  // string # Type of line item, either payment or invoice
  public function getType() {
    return @$this->attributes['type'];
  }

  // date-time # Line item updated at
  public function getUpdatedAt() {
    return @$this->attributes['updated_at'];
  }

  // Parameters:
  //   cursor - string - Used for pagination.  Send a cursor value to resume an existing list from the point at which you left off.  Get a cursor from an existing list via either the X-Files-Cursor-Next header or the X-Files-Cursor-Prev header.
  //   per_page - int64 - Number of records to show per page.  (Max: 10,000, 1,000 or less is recommended).
  public static function list($params = [], $options = []) {
    if (@$params['cursor'] && !is_string(@$params['cursor'])) {
      throw new \Files\InvalidParameterException('$cursor must be of type string; received ' . gettype($cursor));
    }

    if (@$params['per_page'] && !is_int(@$params['per_page'])) {
      throw new \Files\InvalidParameterException('$per_page must be of type int; received ' . gettype($per_page));
    }

    $response = Api::sendRequest('/payments', 'GET', $params, $options);

    $return_array = [];

    foreach ($response->data as $obj) {
      $return_array[] = new AccountLineItem((array)$obj, $options);
    }

    return $return_array;
  }

  public static function all($params = [], $options = []) {
    return self::list($params, $options);
  }

  // Parameters:
  //   id (required) - int64 - Payment ID.
  public static function find($id, $params = [], $options = []) {
    if (!is_array($params)) {
      throw new \Files\InvalidParameterException('$params must be of type array; received ' . gettype($params));
    }

    $params['id'] = $id;

    if (!@$params['id']) {
      throw new \Files\MissingParameterException('Parameter missing: id');
    }

    if (@$params['id'] && !is_int(@$params['id'])) {
      throw new \Files\InvalidParameterException('$id must be of type int; received ' . gettype($id));
    }

    $response = Api::sendRequest('/payments/' . @$params['id'] . '', 'GET', $params, $options);

    return new AccountLineItem((array)(@$response->data ?: []), $options);
  }

  public static function get($id, $params = [], $options = []) {
    return self::find($id, $params, $options);
  }
}
