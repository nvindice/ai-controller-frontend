<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 * @package Controller
 * @subpackage Frontend
 */


namespace Aimeos\Controller\Frontend\Stock\Decorator;


/**
 * Base for stock frontend controller decorators
 *
 * @package Controller
 * @subpackage Frontend
 */
abstract class Base
	extends \Aimeos\Controller\Frontend\Base
	implements \Aimeos\Controller\Frontend\Common\Decorator\Iface, \Aimeos\Controller\Frontend\Stock\Iface
{
	private $controller;


	/**
	 * Initializes the controller decorator.
	 *
	 * @param \Aimeos\Controller\Frontend\Iface $controller Controller object
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\Controller\Frontend\Iface $controller, \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$iface = \Aimeos\Controller\Frontend\Stock\Iface::class;
		$this->controller = \Aimeos\MW\Common\Base::checkClass( $iface, $controller );
	}


	/**
	 * Passes unknown methods to wrapped objects.
	 *
	 * @param string $name Name of the method
	 * @param array $param List of method parameter
	 * @return mixed Returns the value of the called method
	 * @throws \Aimeos\Controller\Frontend\Exception If method call failed
	 */
	public function __call( $name, array $param )
	{
		return @call_user_func_array( array( $this->controller, $name ), $param );
	}


	/**
	 * Adds the SKUs of the products for filtering
	 *
	 * @param array|string $codes Codes of the products
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Stock controller for fluent interface
	 * @since 2019.04
	 */
	public function code( $codes )
	{
		$this->controller->code( $codes );
		return $this;
	}


	/**
	 * Adds generic condition for filtering
	 *
	 * @param string $operator Comparison operator, e.g. "==", "!=", "<", "<=", ">=", ">", "=~", "~="
	 * @param string $key Search key defined by the stock manager, e.g. "stock.dateback"
	 * @param array|string $value Value or list of values to compare to
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Stock controller for fluent interface
	 * @since 2019.04
	 */
	public function compare( $operator, $key, $value )
	{
		$this->controller->compare( $operator, $key, $value );
		return $this;
	}


	/**
	 * Returns the stock item for the given SKU and type
	 *
	 * @param string $code Unique stock code
	 * @param string $type Type assigned to the stock item
	 * @return \Aimeos\MShop\Stock\Item\Iface Stock item
	 * @since 2019.04
	 */
	public function find( $code, $type )
	{
		return $this->controller->find( $code, $type );
	}


	/**
	 * Returns the stock item for the given stock ID
	 *
	 * @param string $id Unique stock ID
	 * @return \Aimeos\MShop\Stock\Item\Iface Stock item
	 * @since 2019.04
	 */
	public function get( $id )
	{
		return $this->controller->get( $id );
	}


	/**
	 * Parses the given array and adds the conditions to the list of conditions
	 *
	 * @param array $conditions List of conditions, e.g. ['>' => ['stock.dateback' => '2000-01-01 00:00:00']]
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Stock controller for fluent interface
	 * @since 2019.04
	 */
	public function parse( array $conditions )
	{
		$this->controller->parse( $conditions );
		return $this;
	}


	/**
	 * Returns the stock items filtered by the previously assigned conditions
	 *
	 * @param integer &$total Parameter where the total number of found stock items will be stored in
	 * @return \Aimeos\MShop\Stock\Item\Iface[] Ordered list of stock items
	 * @since 2019.04
	 */
	public function search( &$total = null )
	{
		return $this->controller->search( $total );
	}


	/**
	 * Sets the start value and the number of returned stock items for slicing the list of found stock items
	 *
	 * @param integer $start Start value of the first stock item in the list
	 * @param integer $limit Number of returned stock items
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Stock controller for fluent interface
	 * @since 2019.04
	 */
	public function slice( $start, $limit )
	{
		$this->controller->slice( $start, $limit );
		return $this;
	}


	/**
	 * Sets the sorting of the result list
	 *
	 * @param string|null $key Sorting of the result list like "stock.type", null for no sorting
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Stock controller for fluent interface
	 * @since 2019.04
	 */
	public function sort( $key = null )
	{
		$this->controller->sort( $key );
		return $this;
	}


	/**
	 * Adds stock types for filtering
	 *
	 * @param array|string $types Stock type codes
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Stock controller for fluent interface
	 * @since 2019.04
	 */
	public function type( $types )
	{
		$this->controller->type( $types );
		return $this;
	}


	/**
	 * Injects the reference of the outmost object
	 *
	 * @param \Aimeos\Controller\Frontend\Iface $object Reference to the outmost controller or decorator
	 * @return \Aimeos\Controller\Frontend\Iface Controller object for chaining method calls
	 */
	public function setObject( \Aimeos\Controller\Frontend\Iface $object )
	{
		parent::setObject( $object );

		$this->controller->setObject( $object );

		return $this;
	}


	/**
	 * Returns the frontend controller
	 *
	 * @return \Aimeos\Controller\Frontend\Stock\Iface Frontend controller object
	 */
	protected function getController()
	{
		return $this->controller;
	}
}
