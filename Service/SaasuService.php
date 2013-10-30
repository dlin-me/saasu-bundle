<?php


namespace Dlin\Bundle\SaasuBundle\Service;


use Dlin\Saasu\SaasuAPI;

class SaasuService
{

    /**
     * This is a holder of tasks scheduled to  execute
     * @var array
     */
    protected $taskSchedule;

    /**
     * @var  \Dlin\Saasu\SaasuApi
     */
    private $api;

    /**
     * Constructor
     *
     * @inheritdoc
     */
    public function __construct($wsacceskey, $file_uid)
    {
        $this->api = new SaasuAPI($wsacceskey, $file_uid);
        $this->taskSchedule = array();
    }


    /**
     *
     * This return the initialized api.
     *
     * @return \Dlin\Saasu\SaasuApi
     *
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return array
     */
    public function getSchedule()
    {
        return $this->taskSchedule;
    }




    /**
     * Exe all tasks in schedule
     */
    public function exeScheduledTasks()
    {

        foreach ($this->taskSchedule as $name => $list) {
            if ($name == 'saveEntity') {
                $this->api->saveEntities($list);
            } else {
                foreach ($list as $data) {
                    $this->api->$name($data);
                }
            }
        }
        $this->taskSchedule = array();

    }


    /**
     *
     * * Schedule an task to exe later. i.e. at the end of the script execution
     *
     * @param $name
     * @param $data
     */
    public function schedule($name, $data)
    {
        if (method_exists($this->api, $name)) {


            if (!isset($this->taskSchedule[$name])) {
                $this->taskSchedule[$name] = array();
            }
            $this->taskSchedule[$name][] = $data;
        }


    }


}