<nav class="laptop:h-screen laptop:w-[200px] w-full h-[100px] laptop:border-r border-b border-black dark:border-white">
    <div class="w-full flex h-full laptop:flex-col laptop:items-center"> 
        <div class="laptop:w-4/5 py-2 mx-10">
            <img class="laptop:h-[100px]" src="/img/baslac.svg">
        </div>
        <div class="flex laptop:w-full h-full 
        laptop:border-t laptop:border-gray-400 laptop:flex-col items-center">
            @include("prefab.item-list", [
                "name" => "Infos",
                "href" => "#",
                "icon" => "info_icon"
            ])
            @include("prefab.item-list", [
                "name" => "Articles",
                "href" => "#",
                "icon" => "article_icon"
            ])
            @include("prefab.item-list", [
                "name" => "Contact",
                "href" => "#",
                "icon" => "contact_icon"
            ])
        </div> 
    </div>
</nav>