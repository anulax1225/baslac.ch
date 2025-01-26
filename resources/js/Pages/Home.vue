<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';

</script>

<template>
    <Head title="Home"/>
    <Layout>
        <template #content>
            <div class="relative w-full h-96 flex items-center overflow-hidden">
                <img src="/img/sarasin.png" class="w-full pb-96">
                <p class="text-center absolute text-white/65 text-[180px] leading-[180px] font-bold left-0 right-0">Scout Baslac</p>
            </div>
            <div class="w-full desktop:px-[17.5%] laptop:px-[12.5%] px-2  flex flex-col">
                <div class="my-5">
                    <p class="w-full text-5xl border-b border-gray-300 pb-2 mb-2 font-semibold">Qui sommes-nous?</p>
                    <p class="mb-2">
                        Le Groupement scout du Bas-Lac existe depuis bientôt trente ans mais repose sur une tradition depuis 1920 sur Saint-Blaise. 
                        La base du scoutisme est la relation avec la nature (respect de l’environnement, reconnaissance de la faune et de la flore, construction de cabanes ou abris, 
                        vivre au milieu de la nature) et la vie en communauté.
                    </p>
                    <p class="mb-2"> 
                        Les samedis après-midi se passent dans la bonne humeur et les jeunes apprennent à faire des jeux de piste 
                        (lire une carte avec boussole, d’un poste à un autre…) à gérer un campement en prenant des responsabilités, 
                        mais aussi à faire des bricolages, constructions et autres projets en fonction de leur âge.
                    </p>
                    <p class="mb-1">Plein d’autres activités sont également au programme :</p>
                    <div class="w-72 grid grid-cols-2 mb-2 mx-auto">
                        <ul class="list-disc">
                            <li>Jeux de rôle</li>
                            <li>Marches</li>
                            <li>Bricolage</li>
                        </ul>
                        <ul class="list-disc">
                            <li>Théâtre</li>
                            <li>Chant</li>
                            <li>Etc.</li>
                        </ul>
                    </div>
                    <p> 
                        Tout ce qui va permette à chacun de se développer, de se connaître. 
                        Et tous les anciens vous le dirons, la solidarité est telle que les groupes de scout vous donnent surtout les meilleurs amis pour la vie.
                    </p>
                </div>
                <div class="my-5">
                    <p class="w-full text-5xl border-b border-gray-300 pb-2 mb-2 font-semibold">Nos groupes par âge</p>
                    <p class="mb-2">Notre groupe est divisé par tranche d'âge allant de 7 à 25 ans pour les participants</p>
                    <ul class="list-disc px-6">
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Les louvetaux</p>
                            <p class="px-3">
                                Dès 7 ans, un enfant peut participer à nos activités en tant que louveteaux. 
                                Répartis en sizaines formant ainsi une meute, les louveteaux découvrent le scoutisme à travers 
                                l’histoire du livre de la jungle et réalisent des jeux, 
                                bricolages ou autres activités adaptées à leur âge.
                            </p>
                        </li>
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Les éclaireurs</p>
                            <p class="px-3">
                                A partir de 11 ans, les jeunes de notre groupe font partie de la branche éclais. Ils sont séparés en patrouilles qui forment une troupe. 
                                Durant les activités préparées et encadrées par les responsables, ils apprennent à devenir autonome en approfondissant certains domaines comme les techniques de corde, 
                                topographie, cuisine, etc. Les plus grands éclais ont également la possibilité d’organiser eux-même des activités ou même des petits camps pour leurs patrouilles. 
                                Les responsables sont là pour leur expliquer comment planifier ces activités et encadrer des enfants plus jeunes.
                            </p>
                        </li>
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Les pioniers</p>
                            <p class="px-3">
                                A la sortie de l’école obligatoire, les jeunes font partie de la branche picos et forme ce que l’on appelle un poste. 
                                Un poste est complètement autonome. Ils planifient en début d’année leur programme composé d’activités et de projets qui leur tiennent à coeur. 
                                Chacun est ensuite tenu de participer à la planification de l’une de ces activités. 
                                Les picos participent également aux activités de groupe et ils n’hésitent pas à donner un coup de main pour aider les responsables à organiser leurs activités !
                            </p>
                        </li>
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Les responsables</p>
                            <p class="px-3">
                                A partir de 17 ans, les membres du groupe deviennent des routiers et forment un clan. 
                                Les routiers s’engagent d’avantage pour le groupe et prennent des responsabilités. 
                                Ils deviennent responsables de branche et planifient et encadrent les activités des louveteaux et des éclais. 
                                Ils suivent également des formations scoutes et Jeunesse + Sport afin d’offrir aux jeunes des activités de qualité. 
                                Les routiers se réunissent également plusieurs fois par année afin de se revoir, 
                                d’échanger et de réaliser des activités et projets tous ensemble sur le thème de leur devise : Servir.
                            </p>
                        </li>
                    </ul> 
                </div>
                <div class="my-5">
                    <p class="w-full text-5xl border-b border-gray-300 pb-2 mb-2 font-semibold">Information pratique</p>
                    <p class="mb-2">Voici les informations principal pour s'engager.</p>
                    <ul class="list-disc px-6">
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Séance</p>
                            <p class="px-3">
                                Nos séances se déroulent de 14h00 à 16h30 chaque samedi hors vacances scolaires à nos locaux. 
                                Il se peut que certaines activités se déroulent hors de nos locaux, si vous souhaitez amener votre enfant pour qu’il s’essaie à nos activités, 
                                n’hésitez pas à nous contacter pour savoir si nous serons à nos locaux à la date voulue. 
                                Si votre enfant souhaite venir essayer le scoutisme lors d’une séance, veuillez nous en informer par email au préalable.
                            </p>
                        </li>
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Organigramme</p>
                            <p class="px-3">
                                Une fois membre du groupe, vous recevrez un organigramme des responsables avec leurs coordonnées. 
                                Celui-ci n’est pas publié sur notre site internet. 
                                Si vous souhaitez avoir le contact de l’un de nos responsables, n’hésitez pas à utiliser notre formulaire.
                            </p>
                        </li>
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Camps et activités spéciales</p>
                            <p class="px-3">
                                Les informations relatives à nos camps ou nos sorties spéciales durant le semestre sont transmises par email. 
                                Il n’est pas prévu de les publier sur cette page internet.
                            </p>
                        </li>
                        <li class="mb-2">
                            <p class="text-lg font-semibold">Nos locaux</p>
                            <p class="px-3 mb-2">
                                Nous faisons toute nos séance dans notre chalet en lisière de la forêt en haut de St-Blaise. 
                                Ce chalet à été fabriquer par des scouts et nous sert depuis 20ans à faire nos séance. 
                            </p>
                        </li>
                    </ul>
                    <iframe
                            class="w-full h-96" 
                            loading="lazy" 
                            src="https://map.geo.admin.ch/embed.html?lang=fr&topic=ech&bgLayer=ch.swisstopo.pixelkarte-farbe&layers=ch.swisstopo.zeitreihen,ch.bfs.gebaeude_wohnungs_register,ch.bav.haltestellen-oev,ch.swisstopo.swisstlm3d-wanderwege,ch.astra.wanderland-sperrungen_umleitungen,KML%7C%7Chttps:%2F%2Fpublic.geo.admin.ch%2Fapi%2Fkml%2Ffiles%2F8zAxcXdzRvCxIN1CAhXGMA&layers_opacity=1,1,1,0.8,0.8,1&layers_visibility=false,false,false,false,false,true&layers_timestamp=18641231,,,,,&E=2564876.26&N=1207554.44&zoom=9"  
                            allow="geolocation" 
                            frameborder="0">
                    </iframe> 
                </div>
            </div>
        </template>
    </Layout>
</template>