<?php

namespace UAM\Propel\Behavior;

use Behavior;

class AddressableBehavior extends Behavior
{
    protected $parameters = array(
        'street_column' => 'street',
        'complement_column' => 'complement',
        'locality_column' => 'locality',
        'region_column' => 'region',
        'postal_code_column' => 'postal_code',
        'country_id_column' => 'country_id',
    );

    protected $objectBuilderModifier;

    public function getObjectBuilderModifier()
    {
        if (is_null($this->objectBuilderModifier)) {
            $this->objectBuilderModifier = new AddressableBehaviorObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }

    public function modifyTable()
    {
        $table = $this->getTable();

        $columnName = $this->getParameter('street_column');
        // add the column if not present
        if (!$this->getTable()->containsColumn($columnName)) {
            $column = $this->getTable()->addColumn(array(
                'name' => $columnName,
                'type' => 'varchar',
                'size' => 36,
                'phpName' => 'Street',
            ));
        }

        $columnName = $this->getParameter('complement_column');
        // add the column if not present
        if (!$this->getTable()->containsColumn($columnName)) {
            $column = $this->getTable()->addColumn(array(
                'name' => $columnName,
                'type' => 'varchar',
                'size' => 36,
                'phpName' => 'Complement',
            ));
        }

        $columnName = $this->getParameter('locality_column');
        // add the column if not present
        if (!$this->getTable()->containsColumn($columnName)) {
            $column = $this->getTable()->addColumn(array(
                'name' => $columnName,
                'type' => 'varchar',
                'size' => 100,
                'phpName' => 'Locality',
            ));
        }

        $columnName = $this->getParameter('region_column');
        // add the column if not present
        if (!$this->getTable()->containsColumn($columnName)) {
            $column = $this->getTable()->addColumn(array(
                'name' => $columnName,
                'type' => 'varchar',
                'size' => 30,
                'phpName' => 'Region',
            ));
        }

        $columnName = $this->getParameter('postal_code_column');
        // add the column if not present
        if (!$this->getTable()->containsColumn($columnName)) {
            $column = $this->getTable()->addColumn(array(
                'name' => $columnName,
                'type' => 'varchar',
                'size' => 20,
                'phpName' => 'PostalCode',
            ));
        }

        $columnName = $this->getParameter('country_id_column');
        // add the column if not present
        if (!$this->getTable()->containsColumn($columnName)) {
            $column = $this->getTable()->addColumn(array(
                'name' => $columnName,
                'type' => 'varchar',
                'size' => 2,
                'phpName' => 'CountryId',
            ));
        }
    }
}
