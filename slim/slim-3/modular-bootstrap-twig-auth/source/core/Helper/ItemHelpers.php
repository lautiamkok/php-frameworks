<?php
/*
 * Common methods.
 */
namespace Spectre\Helper;

// droplet - a small drop of liquid
// snippet - a small and often interesting piece of news, information, or conversation
// driblet - a thin stream or small drop of liquid
// flake - a small, thin piece of something, especially if it has come from a surface covered with a layer of something
trait ItemHelpers
{
    public function getItems($type = null)
    {
        if($type === 'array')
        {
            return $this->toBeArray($this->items);
        }
        elseif($type === 'json')
        {
            return $this->toBeJson($this->items);
        }
        elseif($type === 'object')
        {
            return $this->toBeObject($this->items);
        }
        return $this->items;
    }

    /*
     * Get the data of a row from $this.
     * @return object.
     */
    public function getItem($type = null)
    {
        if($type === 'array')
        {
            return $this->toBeArray($this->item);
        }
        elseif($type === 'json')
        {
            return $this->toBeJson($this->item);
        }
        elseif($type === 'object')
        {
            return $this->toBeObject($this->item);
        }
        return $this->item;
    }

    /*
     * Get total number from $this.
     * @return int.
     */
    public function getTotal()
    {
        return $this->total;
    }

    /*
     * Convert data to object.
     */
    function toBeObject($item)
    {
        return $this->arrayToObject($item);
    }

    /*
     * Convert data to array.
     */
    function toBeArray($item)
    {
        return $this->objectToArray($item);
    }

    /*
     * Convert data to json.
     */
    function toBeJson($item)
    {
        if(is_object($item) === true)
        {
            $item = $this->objectToArray($item);
        }

        if(is_array($item) === true)
        {
            $item = json_encode($item);
        }

        return $item;
    }

    /*
     * Remove numberic keys from item or items.
     * @return $this object.
     */
    function removeNumbericKeys()
    {
        // Call the parent method to remove numberic keys/
        $this->item = $this->removeArrayNumbericKeys($this->item);

        // If the object is not empty.
        if(isset($this->items) && $this->objectHasProperty($this->items) === true)
        {
            // Set empty array.
            $items = [];

            // Loop the object.
            foreach ($this->items as $key => $item)
            {
                // Remove numberic keys.
                $items[$key] = $this->removeArrayNumbericKeys($item);
            }

            // Convert to object and set it back to $this->items.
            $this->items = $items;
        }

        // Return $this for chaining.
        return $this;
    }

    /*
     *  Reverse order.
     */
    function reverseItems()
    {
        $this->items = array_reverse($this->items, false) ;

        // Return $this for chaining.
        return $this;
    }
}
