<?php

use App\Group;
use App\League;
use App\Match;
use App\Team;
use App\Tournament;
use App\Venue;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $league = League::create([
            'name' => 'Mundial',
            'prize' => 7000000,
            'teams' => 32
        ]);

        $tournament = Tournament::create([
            'name' => 'Mundial Rusia 2018',
            'prize' => 70000000,
            'league_id' => $league->id
        ]);


        $groupA = Group::create([
            'name' => 'Grupo A',
            'tournament_id' => $tournament->id
        ]);

        $groupB = Group::create([
            'name' => 'Grupo B',
            'tournament_id' => $tournament->id
        ]);


        $groupC = Group::create([
            'name' => 'Grupo C',
            'tournament_id' => $tournament->id
        ]);

        $groupD = Group::create([
            'name' => 'Grupo D',
            'tournament_id' => $tournament->id
        ]);

        $groupE = Group::create([
            'name' => 'Grupo E',
            'tournament_id' => $tournament->id
        ]);

        $groupF = Group::create([
            'name' => 'Grupo F',
            'tournament_id' => $tournament->id
        ]);

        $groupG = Group::create([
            'name' => 'Grupo G',
            'tournament_id' => $tournament->id
        ]);

        $groupH = Group::create([
            'name' => 'Grupo H',
            'tournament_id' => $tournament->id
        ]);

        $colombia = Team::create([
            'name' => 'Colombia',
            'slug' => str_slug('Colombia'),
            'flag' => url('img/' . 'Colombia.png'),
            'main_color' => '#fdb036',
            'second_color' => '#2c3281',
            'third_color' => '#ffffff',
            'group_id' => $groupH->id
        ]);

        $alemania = Team::create([
            'name' => 'Alemania',
            'slug' => str_slug('Alemania'),
            'flag' => url('img/' . 'Alemania.png'),
            'main_color' => '#000000',
            'second_color' => '#dc1b29',
            'third_color' => '#f8d835',
            'group_id' => $groupF->id
        ]);


        $saudi = Team::create([
            'name' => 'Arabia Saudita',
            'slug' => str_slug('Arabia Saudita'),
            'flag' => url('img/' . 'ArabiaSaudita.png'),
            'main_color' => '#3d9635',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupA->id
        ]);

        $argentina = Team::create([
            'name' => 'Argentina',
            'flag' => url('img/' . 'Argentina.png'),
            'slug' => str_slug('Argentina'),
            'main_color' => '#74acdf',
            'second_color' => '#ffffff',
            'third_color' => '#f6b40e',
            'group_id' => $groupD->id
        ]);

        $australia = Team::create([
            'name' => 'Australia',
            'flag' => url('img/' . 'Australia.png'),
            'slug' => str_slug('Australia'),
            'main_color' => '#003876',
            'second_color' => '#ca202b',
            'third_color' => '#ffffff',
            'group_id' => $groupC->id
        ]);

        $belgica = Team::create([
            'name' => 'Belgica',
            'flag' => url('img/' . 'Belgica.png'),
            'slug' => str_slug('Belgica'),
            'main_color' => '#000000',
            'second_color' => '#f8d835',
            'third_color' => '#dc1b29',
            'group_id' => $groupG->id
        ]);

        $brasil = Team::create([
            'name' => 'Brasil',
            'flag' => url('img/' . 'Brasil.png'),
            'slug' => str_slug('Brasil'),
            'main_color' => '#219256',
            'second_color' => '#f8e334',
            'third_color' => '#042c81',
            'group_id' => $groupE->id
        ]);

        $corea = Team::create([
            'name' => 'Corea Del Sur',
            'flag' => url('img/' . 'CoreaDelSur.png'),
            'slug' => str_slug('Corea Del Sur'),
            'main_color' => '#da1c27',
            'second_color' => '#11549d',
            'third_color' => '#ffffff',
            'group_id' => $groupF->id
        ]);

        $costa = Team::create([
            'name' => 'Costa Rica',
            'flag' => url('img/' . 'CostaRica.png'),
            'slug' => str_slug('Costa Rica'),
            'main_color' => '#04307c',
            'second_color' => '#cc172d',
            'third_color' => '#ffffff',
            'group_id' => $groupE->id
        ]);

        $dinamarca = Team::create([
            'name' => 'Dinamarca',
            'flag' => url('img/' . 'Dinamarca.png'),
            'slug' => str_slug('Dinamarca'),
            'main_color' => '#be003a',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupC->id
        ]);

        $egipto = Team::create([
            'name' => 'Egipto',
            'flag' => url('img/' . 'Egipto.png'),
            'slug' => str_slug('Egipto'),
            'main_color' => '#bc0030',
            'second_color' => '#ffffff',
            'third_color' => '#000000',
            'group_id' => $groupA->id
        ]);


        $espana = Team::create([
            'name' => 'Espana',
            'flag' => url('img/' . 'Espana.png'),
            'slug' => str_slug('Espana'),
            'main_color' => '#d91b26',
            'second_color' => '#fdc32d',
            'third_color' => '#ffffff',
            'group_id' => $groupB->id
        ]);

        $fracia = Team::create([
            'name' => 'Francia',
            'flag' => url('img/' . 'Francia.png'),
            'slug' => str_slug('Francia'),
            'main_color' => '#2c3281',
            'second_color' => '#dc1b29',
            'third_color' => '#ffffff',
            'group_id' => $groupC->id
        ]);

        $islandia = Team::create([
            'name' => 'Islandia',
            'flag' => url('img/' . 'Islandia.png'),
            'slug' => str_slug('Islandia'),
            'main_color' => '#223693',
            'second_color' => '#c51d32',
            'third_color' => '#ffffff',
            'group_id' => $groupD->id
        ]);

        $japon = Team::create([
            'name' => 'Japon',
            'flag' => url('img/' . 'Japon.png'),
            'slug' => str_slug('Japon'),
            'main_color' => '#d41022',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupH->id
        ]);

        $marruecos = Team::create([
            'name' => 'Marruecos',
            'flag' => url('img/' . 'Marruecos.png'),
            'slug' => str_slug('Marruecos'),
            'main_color' => '#b01f35',
            'second_color' => '#296437',
            'third_color' => null,
            'group_id' => $groupB->id
        ]);

        $portugal = Team::create([
            'name' => 'Portugal',
            'flag' => url('img/' . 'Portugal.png'),
            'slug' => str_slug('Portugal'),
            'main_color' => '#209156',
            'second_color' => '#d91b26',
            'third_color' => '#fce12e',
            'group_id' => $groupB->id
        ]);

        $iran = Team::create([
            'name' => 'Iran',
            'flag' => url('img/' . 'Iran.png'),
            'slug' => str_slug('Iran'),
            'main_color' => '#219257',
            'second_color' => '#d91b26',
            'third_color' => '#ffffff',
            'group_id' => $groupB->id
        ]);


        $mexico = Team::create([
            'name' => 'Mexico',
            'flag' => url('img/' . 'Mexico.png'),
            'slug' => str_slug('Mexico'),
            'main_color' => '#2c6949',
            'second_color' => '#ffffff',
            'third_color' => '#bc0030',
            'group_id' => $groupF->id
        ]);

        $nigeria = Team::create([
            'name' => 'Nigeria',
            'flag' => url('img/' . 'Nigeria.png'),
            'slug' => str_slug('Nigeria'),
            'main_color' => '#0e7837',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupD->id
        ]);

        $croacia = Team::create([
            'name' => 'Croacia',
            'flag' => url('img/' . 'Croacia.png'),
            'slug' => str_slug('Croacia'),
            'main_color' => '#cb0028',
            'second_color' => '#1e2788',
            'third_color' => '#ffffff',
            'group_id' => $groupD->id
        ]);

        $panama = Team::create([
            'name' => 'Panama',
            'flag' => url('img/' . 'Panama.png'),
            'slug' => str_slug('Panama'),
            'main_color' => '#c0003b',
            'second_color' => '#ffffff',
            'third_color' => '#3564c2',
            'group_id' => $groupG->id
        ]);

        $peru = Team::create([
            'name' => 'Peru',
            'flag' => url('img/' . 'Peru.png'),
            'slug' => str_slug('Peru'),
            'main_color' => '#ba0019',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupC->id
        ]);


        $polonia = Team::create([
            'name' => 'Polonia',
            'flag' => url('img/' . 'Polonia.png'),
            'slug' => str_slug('Polonia'),
            'main_color' => '#d80031',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupH->id
        ]);

        $rusia = Team::create([
            'name' => 'Rusia',
            'flag' => url('img/' . 'Rusia.png'),
            'slug' => str_slug('Rusia'),
            'main_color' => '#11549d',
            'second_color' => '#ffffff',
            'third_color' => '#11549d',
            'group_id' => $groupA->id
        ]);


        $senegal = Team::create([
            'name' => 'Senegal',
            'flag' => url('img/' . 'Senegal.png'),
            'slug' => str_slug('Senegal'),
            'main_color' => '#219257',
            'second_color' => '#fee93a',
            'third_color' => '#d91b26',
            'group_id' => $groupH->id
        ]);

        $serbia = Team::create([
            'name' => 'Serbia',
            'flag' => url('img/' . 'Serbia.png'),
            'slug' => str_slug('Serbia'),
            'main_color' => '#313d83',
            'second_color' => '#ffffff',
            'third_color' => '#c90031',
            'group_id' => $groupE->id
        ]);

        $suecia = Team::create([
            'name' => 'Suecia',
            'flag' => url('img/' . 'Suecia.png'),
            'slug' => str_slug('Suecia'),
            'main_color' => '#2d5a95',
            'second_color' => '#f3d02f',
            'third_color' => null,
            'group_id' => $groupF->id
        ]);


        $suiza = Team::create([
            'name' => 'Suiza',
            'flag' => url('img/' . 'Suiza.png'),
            'slug' => str_slug('Suiza'),
            'main_color' => '#dc1b29',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupE->id
        ]);

        $tunez = Team::create([
            'name' => 'Tunez',
            'flag' => url('img/' . 'Tunez.png'),
            'slug' => str_slug('Tunez'),
            'main_color' => '#d30025',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupG->id
        ]);

        $inglaterra = Team::create([
            'name' => 'Inglaterra',
            'flag' => url('img/' . 'Inglaterra.png'),
            'slug' => str_slug('Inglaterra'),
            'main_color' => '#d91b26',
            'second_color' => '#ffffff',
            'third_color' => null,
            'group_id' => $groupG->id
        ]);

        $uruguay = Team::create([
            'name' => 'Uruguay',
            'flag' => url('img/' . 'Uruguay.png'),
            'slug' => str_slug('Uruguay'),
            'main_color' => '#0038a8',
            'second_color' => '#ffffff',
            'third_color' => '#fcd116',
            'group_id' => $groupA->id
        ]);

        //stadiums
        $luzhniki = Venue::create([
            'name' => 'Luzhniki Stadium',
            'city' => 'Moscow',
            'capacity' => 81006,
            'country' => 'Rusia'
        ]);


        $spartak = Venue::create([
            'name' => 'Spartak Stadium',
            'city' => 'Moscow',
            'capacity' => 43298,
            'country' => 'Rusia'
        ]);

        $nizhny = Venue::create([
            'name' => 'Nizhny Novgorod Stadium',
            'city' => 'Nizhny Novgorod',
            'capacity' => 45331,
            'country' => 'Rusia'
        ]);

        $mordovia = Venue::create([
            'name' => 'Mordovia Arena',
            'city' => 'Saransk',
            'capacity' => 44442,
            'country' => 'Rusia'
        ]);

        $kazan = Venue::create([
            'name' => 'Kazan Arena',
            'city' => 'Kazan',
            'capacity' => 44779,
            'country' => 'Rusia'
        ]);

        $samara = Venue::create([
            'name' => 'Samara Arena',
            'city' => 'Samara',
            'capacity' => 44807,
            'country' => 'Rusia'
        ]);

        $stPetesburg = Venue::create([
            'name' => 'St Petersburg Stadium',
            'city' => 'St. Petersburg ',
            'capacity' => 68134,
            'country' => 'Rusia'
        ]);

        $ekaterinburg = Venue::create([
            'name' => 'Ekaterinburg Arena',
            'city' => 'Ekaterinburg',
            'capacity' => 35696,
            'country' => 'Rusia'
        ]);

        $kaliningrad = Venue::create([
            'name' => 'Kaliningrad Stadium',
            'city' => 'Kaliningrad',
            'capacity' => 35212,
            'country' => 'Rusia'
        ]);

        $volgograd = Venue::create([
            'name' => 'Volgograd Arena',
            'city' => 'Volgograd',
            'capacity' => 45568,
            'country' => 'Rusia'
        ]);

        $rostov = Venue::create([
            'name' => 'Rostov Arena',
            'city' => 'Rostov-on-Don',
            'capacity' => 45145,
            'country' => 'Rusia'
        ]);

        $fisht = Venue::create([
            'name' => 'Fisht Stadium',
            'city' => 'Sochi',
            'capacity' => 47700,
            'country' => 'Rusia'
        ]);


        $matches = $this->getWorldCupData();

        foreach($matches as $index => $match) {
            if($index !== 0) {
                $time = Carbon::createFromFormat('d/m/Y H:i', $match[1], 'Europe/Moscow');

                $knockout = $match[0] === '1' || $match[0] === '2' || $match[0] === '3' ? false : true;

                $home = Team::where('slug',str_slug($match[4]))->first();
                $away = Team::where('slug',str_slug($match[5]))->first();
                $venue = Venue::where('name','LIKE', ucfirst($match[2]) . '%')->first();
                $group = !empty($match[6]) ? Group::where('name', $match[6])->first() : null;

                Match::create([
                    'number' => $match[0],
                    'play_at' => $time, //turn time into carbon
                    'knockout' => $knockout, //is this a knockout
                    'home_id' => isset($home) ? $home->id : null,//find team by name
                    'away_id' => isset($away) ? $away->id : null,//find team by name
                    'venue_id' => isset($venue) ? $venue->id : null,//find venue by name
                    'group_id' => isset($group) ? $group->id : null ,//find venue by name
                ]);
            }
        }

    }

    protected function getWorldCupData()
    {
        $file = storage_path('app/fifa-world-cup-2018-et.csv');
        $row = 1;
        $fileData = [];

        if (($handle = fopen($file, "rw")) !== false) {
            while (($data = fgetcsv($handle, 1000, "\n")) !== false) {
                $num = count($data);
                $row++;
                for ($c = 0; $c < $num; $c++) {
                    $fileData[] = explode(',', $data[$c]);
                }
            }
            fclose($handle);
        }

        return $fileData;
    }
}
