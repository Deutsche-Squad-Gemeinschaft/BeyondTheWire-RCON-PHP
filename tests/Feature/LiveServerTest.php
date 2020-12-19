<?php

namespace DSG\BeyondTheWireRCON\Tests\Feature;

use DSG\BeyondTheWireRCON\Data\ServerConnectionInfo;
use DSG\BeyondTheWireRCON\BeyondTheWireServer;

class LiveServerTest extends \DSG\BeyondTheWireRCON\Tests\TestCase {
    private BeyondTheWireServer $btwServer;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->btwServer = new BeyondTheWireServer(new ServerConnectionInfo('172.17.0.2', 21114, 'secret'));
    }

    /**
     * Verifies the currentMap can properly be retrieved.
     *
     * @return void
     */
    public function test_current_map()
    {
        $this->assertSame('Al Basrah AAS v1', $this->btwServer->currentMap());
    }

    /**
     * Verifies the set next map command does work properly
     * 
     * @return void
     */
    public function test_admin_set_next_map()
    {
        $this->assertTrue($this->btwServer->adminSetNextMap('Al Basrah Insurgency v1'));
    }

    /**
     * Verifies the nextMap can properly be retrieved.
     *
     * @return void
     */
    public function test_next_map()
    {
        $this->assertSame('Al Basrah Insurgency v1', $this->btwServer->nextMap());
    }

    /**
     * Verifies the player list can properly be retrieved.
     *
     * @return void
     */
    public function test_list_players()
    {
        $players = $this->btwServer->listPlayers();

        $this->assertCount(0, $players);
    }

    /**
     * Verifies the disconnected player list can properly be retrieved.
     *
     * @return void
     */
    public function test_list_disconnected_players()
    {
        $playerList = $this->btwServer->listDisconnectedPlayers();

        $this->assertCount(0, $playerList);
    }

    /**
     * Verifies the team/squad list can properly be retrieved.
     *
     * @return void
     */
    public function test_list_squads()
    {
        $teams = $this->btwServer->listSquads();

        foreach ($teams as $team) {
            $this->assertSame(0, count($team->getSquads()));
        }
    }

    /**
     * Verifies the server population can properly be retrieved.
     *
     * @return void
     */
    public function test_server_population()
    {
        $teams = $this->btwServer->serverPopulation();

        $squadCount = 0;
        $playerCount = 0;
        foreach ($teams as $team) {
            $squadCount += count($team->getSquads());
            $teamPlayerCount = count($team->getPlayers());
            foreach ($team->getSquads() as $squad) {
                $teamPlayerCount += count($squad->getPlayers());
            }
            $playerCount += $teamPlayerCount;
        }
        
        $this->assertSame(0, $squadCount);
        $this->assertSame(0, $playerCount);
    }

    /**
     * Verifies the broadcast command does work properly
     * 
     * @return void
     */
    public function test_admin_Broadcast()
    {
        $this->assertTrue($this->btwServer->adminBroadcast('Hello World!'));
    }

    /**
     * Verifies the change map command does work properly
     * 
     * @return void
     */
    public function test_admin_change_map()
    {
        $this->assertTrue($this->btwServer->adminChangeMap('Al Basrah AAS v1'));
    }

    /**
     * Verifies the restart match command does work properly
     * 
     * @return void
     */
    public function test_admin_restart_match()
    {
        $this->assertTrue($this->btwServer->adminRestartMatch());

        sleep(30);
    }

    /**
     * Verifies the end match command does work properly
     * 
     * @return void
     */
    public function test_admin_end_match()
    {
        $this->assertTrue($this->btwServer->adminEndMatch());

        sleep(30);
    }

    /**
     * Verifies the admin set max num players command does work properly
     * 
     * @return void
     */
    public function test_admin_set_max_num_players()
    {
        $this->assertTrue($this->btwServer->adminSetMaxNumPlayers(78));
    }

    /**
     * Verifies the admin set max num players command does work properly
     * 
     * @return void
     */
    public function test_admin_set_password()
    {
        $this->assertTrue($this->btwServer->adminSetServerPassword('secret'));
    }

    /**
     * Verifies the disconnect method works without any exception
     * 
     * @return void
     */
    public function test_squad_server_admin_slomo()
    {
        $this->assertTrue($this->btwServer->adminSlomo(2));
    }

    /**
     * Verifies the disconnect method works without any exception
     * 
     * @return void
     */
    public function test_squad_server_disconnect()
    {
        $this->assertNull($this->btwServer->disconnect());
    }
}