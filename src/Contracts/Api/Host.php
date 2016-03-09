<?php

namespace Benmag\Rancher\Contracts\Api;

/**
 * A Host is the most basic unit of resource within Rancher.
 * It represents any Linux server, virtual or physical.
 *
 * @package  Rancher
 * @author   @benmagg
 */
interface Host {


    /**
     * {@inheritdoc}
     */
    public function all();

    /**
     * {@inheritdoc}
     */
    public function get($id);

    /**
     * {@inheritdoc}
     */
    public function update($id, $host);

    /**
     * {@inheritdoc}
     */
    public function delete($id);




    /**
     * Activate a host
     *
     * @param $id
     * @return \Benmag\Rancher\Factories\Entity\Host
     */
    public function activate($id);

    /**
     * Deactivates a host
     *
     * @param $id
     * @return \Benmag\Rancher\Factories\Entity\Host
     */
    public function deactivate($id);

    /**
     * Remove a host
     *
     * @param $id
     * @return \Benmag\Rancher\Factories\Entity\Host
     */
    public function remove($id);

    /**
     * Restore a host
     *
     * @param $id
     * @return \Benmag\Rancher\Factories\Entity\Host
     */
    public function restore($id);

}