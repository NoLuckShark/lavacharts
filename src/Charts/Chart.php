<?php

namespace Khill\Lavacharts\Charts;

use JsonSerializable;
use Khill\Lavacharts\Support\Options;
use Khill\Lavacharts\Values\Label;
use Khill\Lavacharts\Values\ElementId;
use Khill\Lavacharts\Support\Contracts\Arrayable;
use Khill\Lavacharts\Support\Contracts\Customizable;
use Khill\Lavacharts\Support\Contracts\DataTable;
use Khill\Lavacharts\Support\Contracts\Jsonable;
use Khill\Lavacharts\Support\Contracts\JsPackage;
use Khill\Lavacharts\Support\Contracts\Renderable;
use Khill\Lavacharts\Support\Contracts\Wrappable;
use Khill\Lavacharts\Support\Traits\HasOptionsTrait as HasOptions;
use Khill\Lavacharts\Support\Traits\RenderableTrait as IsRenderable;
use Khill\Lavacharts\Support\Traits\HasDataTableTrait as HasDataTable;

/**
 * Class Chart
 *
 * Parent to all charts which has common properties and methods
 * used between all the different charts.
 *
 *
 * @package       Khill\Lavacharts\Charts
 * @author        Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2017, KHill Designs
 * @link          http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link          http://lavacharts.com                   Official Docs Site
 * @license       http://opensource.org/licenses/MIT      MIT
 */
class Chart implements DataTable, Customizable, Renderable, Wrappable, Jsonable, Arrayable, JsPackage, JsonSerializable
{
    use HasDataTable, HasOptions, IsRenderable;

    /**
     * Type of wrappable class
     */
    const WRAP_TYPE = 'chartType';

    /**
     * Builds a new chart with the given label.
     *
     * @param \Khill\Lavacharts\Values\Label         $chartLabel Identifying label for the chart.
     * @param \Khill\Lavacharts\DataTables\DataTable $datatable  DataTable used for the chart.
     * @param array                                  $options    Options fot the chart.
     */
    public function __construct(Label $chartLabel, DataTable $datatable = null, array $options = [])
    {
        $this->label = $chartLabel;
        $this->datatable = $datatable->getDataTable();
        $this->options = new Options($options);

        if ($this->options->has('elementId')) {
            $this->elementId = new ElementId($options->elementId);
        }
    }

    /**
     * Returns the chart type.
     *
     * @since  3.0.0
     * @return string
     */
    public function getType()
    {
        return static::TYPE;
    }

    /**
     * Returns the Filter wrap type.
     *
     * @since  3.0.5
     * @return string
     */
    public function getWrapType()
    {
        return static::WRAP_TYPE;
    }

    /**
     * Returns the chart version.
     *
     * @since  3.0.5
     * @return string
     */
    public function getVersion()
    {
        return static::VERSION;
    }

    /**
     * Returns the chart visualization class.
     *
     * @since  3.0.5
     * @return string
     */
    public function getJsPackage()
    {
        return static::VISUALIZATION_PACKAGE;
    }

    /**
     * Returns the chart visualization package.
     *
     * @since  3.0.5
     * @return string
     */
    public function getJsClass()
    {
        return 'google.visualization.' . static::TYPE;
    }

    /**
     * Array representation of the Chart.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'type'       => $this->getType(),
            'label'      => $this->getLabel(),
            'options'    => $this->getOptions(),
            'datatable'  => $this->getDataTable(),
            'element_id' => $this->getElementId(),
        ];
    }

    /**
     * Return a JSON representation of the chart.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this);
    }

    /**
     * Custom serialization of the chart.
     *
     * @return array
     */
    function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Retrieves the events if any have been assigned to the chart.
     *
     * @since  3.0.5
     * @return array
     */
    public function getEvents()
    {
        return $this['events'];
    }

    /**
     * Checks if any events have been assigned to the chart.
     *
     * @return bool
     */
    public function hasEvents()
    {
        return isset($this['events']);
    }

    /**
     * Sets any configuration option, with no checks for type / validity
     *
     *
     * This is method was added in 2.5 as a bandaid to remove the handcuffs from
     * users who want to add options that Google has added, that I have not.
     * I didn't intend to restrict the user to only select options, as the
     * goal was to type isNonEmpty and validate. This method can be used to set
     * any option, just pass in arrays with key value pairs for any setting.
     *
     * If the setting is an object, per the google docs, then use multi-dimensional
     * arrays and they will be converted upon rendering.
     *
     * @since  3.0.0
     * @param  array $options Array of customization options for the chart
     * @return \Khill\Lavacharts\Charts\Chart
     */
    public function customize(array $options)
    {
        $this->setOptions($options);

        return $this;
    }
}
