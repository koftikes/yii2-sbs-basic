<?php

use app\models\News;
use sbs\helpers\TransliteratorHelper;

$date = date('Y-m-d H:i:s');

if (!function_exists('generate')) {
    function generate($slug)
    {
        return \mb_strtolower(TransliteratorHelper::process(\str_replace(' ', '-', $slug)));
    }
}

return [
    'asia'   => [
        'category_id'  => 9,
        'title'        => 'Spirited Away: Japanese anime trounces Toy Story 4 at China box office',
        'slug'         => generate('Spirited Away: Japanese anime trounces Toy Story 4 at China box office'),
        'image'        => null,
        'preview'      => '<p>Japanese animation Spirited Away has dominated the Chinese box office over its opening weekend, making more than twice as much as Disney\'s Toy Story 4.</p>',
        'text'         => '<p>The Studio Ghibli film grossed $27.7m (£21.8m), according to Maoyan, China\'s largest movie ticketing app.</p><p>Spirited Away was officially released in 2001, but only now, 18 years later, has it been released in China.</p><p>However, many Chinese viewers grew up with the film, having watched DVDs or pirated downloads.</p><ul><li>Toy Story 4 breaks global box office record</li><li>Hayao Miyazaki: Japan\'s godfather of animation?</li></ul><p>Toy Story 4 made $13.2m on its opening weekend, said consultancy firm Artisan Gateway.</p><p>The Japanese film by famed director Hayao Miyazaki tells the story of a young girl who is transported into a fantasy world after entering an abandoned theme park with her parents.</p><p>The movie gained a cult following after it was released and still remains Studio Ghibli\'s highest grossing movie of all time.</p><p>It also became the first non-English language animated film to win an Academy Award.</p><p>My Neighbour Totoro became the first Ghibli film to ever debut in theatres in China in 2018, 30 years after its original release.</p><p>China has a strict quota on the number of foreign films it shows.</p><p>One analyst told the BBC last year that political tensions between China and Japan in the past could be why some Japanese movies had not been aired in China until very recently.</p><p>Japan occupied China in 1931 and millions of Chinese people had been killed by the time the war ended in 1945. But for many, feelings of resentment towards Japan lingered.</p><p>"Right now that relationship has improved significantly and there is a lot of movement on Sino-Japanese co-productions, including in anime," Stanley Rosen from the University of Southern California said.</p><p>Spirited Away has also already outperformed Totoro which grossed $27.3m for its full run, state media outlet CGTN reports.</p>',
        'views'        => 150,
        'status'       => News::STATUS_ENABLE,
        'publish_date' => $date,
        'create_user'  => 1,
        'update_user'  => 1,
        'create_date'  => $date,
        'update_date'  => $date,
    ],
    'usa'    => [
        'category_id'  => 8,
        'title'        => 'Migrant children crisis: Democrats agree $4.5bn aid for migrants at border',
        'slug'         => generate('Migrant children crisis: Democrats agree $4.5bn aid for migrants at border'),
        'image'        => null,
        'preview'      => '<p>Democrats in the US House of Representatives have approved $4.5bn (£3.5bn) in humanitarian aid for the southern border.</p>',
        'text'         => '<p>Several migrant deaths, coupled with reports of "severely neglected" children at a Texan border patrol station, have helped shape the debate.</p><p>But the bill faces a tough path through the Republican-controlled Senate.</p><p>It is considering a rival bill with fewer restrictions on how border agencies can spend the money.</p><p>The Democrats\' version, in contrast, contains several strict rules setting out that the funds can be used for humanitarian aid only, and "not for immigration raids, not detention beds, not a border wall", a statement from House appropriations committee chair Nita Lowey said.</p><p>The bill was toughened up after some Democrats expressed concern over providing extra funds for agencies involved in the current situation, including those enforcing President Donald Trump\'s "zero tolerance" policy which had last year led to migrant children being separated from their parents.</p><ul><li>Drowning photo exposes US border risk for migrants</li><li>Is there a crisis on the US-Mexico border?</li></ul><p>With the extra safeguards, it passed 230 to 195, roughly along party lines - with a few Democrats still refusing to back it.</p><p>The White House said President Trump would be advised to veto the House bill if it landed on his desk "in its current form".</p><p>The administration accused the Democrats of seeking to "take advantage of the current crisis".</p><h2>Why is there a political crisis about the border?</h2><p>Mr Trump\'s "zero tolerance" policy was announced in early 2018. By prosecuting adults who crossed the border illegally, it had the effect of separating children from their parents.</p><p>Despite a court order requiring families to be reunited and an end to separations last year, hundreds remain in government shelters, to which the public - including journalists and rights activists - had little access.</p><p>On Wednesday, Mr Trump again blamed his predecessor for separations and the facilities in which migrant children have been held.</p><p>"I\'m going to put people together, but there\'s going to be more people coming up," the president told Fox News\' Maria Bartiromo.</p><p>"We\'ve done a great job - a much better job than Obama - you know, Obama built all those cells."</p><p>While it is true that some of the centres were built under President Barack Obama\'s tenure, family separations became routine after Mr Trump\'s "zero-tolerance" policy was implemented.</p><p>This was because previous administrations did not automatically refer families entering the US illegally for criminal proceedings, which then require separating children from detained parents to comply with existing US laws regarding child migrants.</p>',
        'views'        => 89000,
        'status'       => News::STATUS_ENABLE,
        'publish_date' => $date,
        'create_user'  => 2,
        'update_user'  => 2,
        'create_date'  => $date,
        'update_date'  => $date,
    ],
    'europe' => [
        'category_id'  => 7,
        'title'        => 'France heatwave: Paris region closes schools',
        'slug'         => generate('France heatwave: Paris region closes schools'),
        'image'        => null,
        'preview'      => '<p>France is starting to close dozens of schools because of a heatwave, with temperatures expected to climb above 40C (104F) in some regions on Thursday.</p>',
        'text'         => '<p>About 50 schools in the Essonne region, just south of Paris, are being shut, as they lack sufficient air conditioning.</p><p>On Thursday, French BFMTV says, schools will also be shut in the Val-de-Marne and Seine-et-Marne regions near Paris.</p><p>In parts of northeastern Spain the heat is expected to reach 45C on Friday. Germany and Italy are still below 40C.</p><p>The exceptionally hot air has blown in from the Sahara.</p><p>Switzerland is also sizzling, but there the authorities insist that schools will remain open, because working parents cannot be expected to look after their children during the day.</p><p>French officials decided that in Paris and Lyon only the least polluting vehicles would be allowed on the roads from Wednesday. Paris is especially prone to smog in hot weather.</p><p>Parisian drivers are also being offered free parking places to encourage them to use public transport instead.</p><p style="text-align: center;"><iframe src="//www.youtube.com/embed/z0NfI2NeDHI" frameborder="0" allowfullscreen="" style="text-align: left; width: 500px; height: 281px;"></iframe><br></p><p>France was traumatised by a heatwave in 2003 which was blamed for 15,000 extra deaths.</p><ul><li>In pictures: Europe seeks relief from the heat</li><li>France braces for 40C heatwave</li></ul><p>Nearly all of France is now on orange alert - the second-highest warning level after red - with local authorities issuing advice on how to keep cool.</p><p>A Spanish weather forecaster tweeted a map of Spain turning dark red, with the message: "Hell is coming."</p>',
        'views'        => 2000569,
        'status'       => News::STATUS_ENABLE,
        'publish_date' => $date,
        'create_user'  => 3,
        'update_user'  => 2,
        'create_date'  => $date,
        'update_date'  => $date,
    ],
];
