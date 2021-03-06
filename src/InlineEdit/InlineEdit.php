<?php

/**
 * @copyright   Copyright (c) 2015 ublaboo <ublaboo@paveljanda.com>
 * @author      Pavel Janda <me@paveljanda.com>
 * @package     Ublaboo
 */

namespace Ublaboo\DataGrid\InlineEdit;

use Nette;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;
use Nette\Utils\Html;
use Ublaboo\DataGrid\Traits;

/**
 * @method onSubmit($id, Nette\Utils\ArrayHash $values)
 * @method onSubmit(Nette\Utils\ArrayHash $values)
 * @method onControlAdd(Nette\Forms\Container $container)
 * @method onSetDefaults(Nette\Forms\Container $container, $item)
 */
class InlineEdit extends Nette\Object
{

	use Traits\TButton;

	/**
	 * @var callable[]
	 */
	public $onSubmit;

	/**
	 * @var callable[]
	 */
	public $onControlAdd;

	/**
	 * @var callable[]
	 */
	public $onSetDefaults;

	/**
	 * @var callable[]
	 */
	public $onCustomRedraw;

	/**
	 * @var mixed
	 */
	protected $item_id;

	/**
	 * @var DataGrid
	 */
	protected $grid;

	/**
	 * @var string|NULL
	 */
	protected $primary_where_column;

	/**
	 * Inline adding - render on the top or in the bottom?
	 * @var bool
	 */
	protected $position_top = FALSE;


	/**
	 * @param DataGrid $grid
	 * @param string|NULL   $primary_where_column
	 */
	public function __construct(DataGrid $grid, $primary_where_column = NULL)
	{
		$this->grid = $grid;
		$this->primary_where_column = $primary_where_column;

		$this->title = 'ublaboo_datagrid.edit';
		$this->class = 'btn btn-xs btn-default ajax';
		$this->icon = 'pencil';
	}


	/**
	 * @param mixed $id
	 */
	public function setItemId($id)
	{
		$this->item_id = $id;
	}


	/**
	 * @return mixed
	 */
	public function getItemId()
	{
		return $this->item_id;
	}


	/**
	 * @return string
	 */
	public function getPrimaryWhereColumn()
	{
		return $this->primary_where_column;
	}


	/**
	 * Render row item detail button
	 * @param  Row $row
	 * @return Html
	 */
	public function renderButton($row)
	{
		$a = Html::el('a')
			->href($this->grid->link('inlineEdit!', ['id' => $row->getId()]));

		$this->tryAddIcon($a, $this->getIcon(), $this->getText());

		$a->addText($this->text);

		if ($this->title) { $a->title($this->title); }
		if ($this->class) { $a->class[] = $this->class; }

		$a->class[] = 'datagrid-inline-edit-trigger';

		return $a;
	}


	/**
	 * Render row item detail button
	 * @return Html
	 */
	public function renderButtonAdd()
	{
		$a = Html::el('a')->data('datagrid-toggle-inline-add', TRUE);

		$this->tryAddIcon($a, $this->getIcon(), $this->getText());

		$a->addText($this->text);

		if ($this->title) { $a->title($this->title); }
		if ($this->class) { $a->class($this->class); }

		return $a;
	}


	/**
	 * Setter for inline adding position
	 * @param bool $position_top
	 * @return static
	 */
	public function setPositionTop($position_top = TRUE)
	{
		$this->position_top = (bool) $position_top;

		return $this;
	}


	/**
	 * Getter for inline adding
	 * @return bool
	 */
	public function isPositionTop()
	{
		return $this->position_top;
	}


	/**
	 * @return bool
	 */
	public function isPositionBottom()
	{
		return !$this->position_top;
	}

}
