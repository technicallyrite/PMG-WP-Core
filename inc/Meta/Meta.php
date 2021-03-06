<?php
/**
 * A simple wrapper around the metadata API that auto prefixes things.
 *
 * @since       1.0
 * @author      Christopher Davis <chris@pmg.co>
 * @license     http://opensource.org/licenses/MIT MIT
 * @copyright   Performance Media Group 2012
 * @package     PMGCore
 */

namespace PMG\Core\Meta;

!defined('ABSPATH') && exit;

class Meta implements MetaInterface
{
    private $prefix;

    private $type;

    public function __construct($type, $prefix)
    {
        $this->type = $type;
        $this->prefix = $prefix;
    }

    public function get_key($k)
    {
        return "_{$this->prefix}_{$k}";
    }

    public function save($id, $key, $val)
    {
        $old = $this->get($id, $key);

        return update_metadata(
            $this->type,
            $id,
            $this->get_key($key),
            $val,
            $old
        );
    }

    public function get($id, $key, $default='')
    {
        $v = get_metadata(
            $this->type,
            $id,
            $this->get_key($key),
            true
        );

        return $v ? $v : $default;
    }

    public function delete($id, $key, $val='')
    {
        return delete_metadata(
            $this->type,
            $id,
            $this->get_key($key),
            $val
        );
    }

    public function delete_all($id, $key, $val='')
    {
        return delete_metadata(
            $this->type,
            $id,
            $this->get_key($key),
            $val,
            true
        );
    }
} // end Meta
