<div>
    <div class="h-100 overflow-y-scroll" >

        <!-- User box -->
        <div class="user-box text-center">
            <img src="/assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                 class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                   data-bs-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <span class="fa fa-blog pr-3"></span>
                    <b>Général</b>
                </li>
                <x-menu-link link="/" label="Tableau de bord" icon="icon-home pr-1"  />
                <x-menu-link :link="route('home.search')" label="Recherche"   icon="icon-magnifier pr-1"/>

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <span class="fa fa-home pr-3"></span>
                    <b>Acceuil</b>
                </li>
                <x-menu-link :link="route('home.patient_add')" label="Nouveau patient"  icon="icon-user-follow pr-1"/>
                <x-menu-link :link="route('home.patient_list')" label="Patient en attentes" icon="icon-people pr-1" />

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <span class="fa fa-heartbeat pr-3"></span>
                    <b>Urgence</b>
                </li>
                <x-menu-link :link="route('urgence.patient_add')" label="Nouveau patient"  icon="icon-user-follow pr-1"/>
                <x-menu-link :link="route('urgence.patient_list')" label="Liste des patients" icon="icon-people pr-1" />




                <li class="menu-title bg-gray-100 border-2 border-green">
                    <i class="fas fa-bed-pulse pr-3"></i>
                    <b>Hospitalisation</b>
                </li>

                <x-menu-link :link="route('hospi.index')" label="Liste des Patients" icon="icon-calender pr-1" />
                <x-menu-link :link="route('hospi.chambre')" label="Unités" icon="icon-home pr-1" />

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <span class="fas fa-layout-group pr-3"></span>
                    <b>Services</b>
                </li>
                @foreach($services as $service)
                    <x-menu-link :link="route('services.liste', ['service'=>$service])" :label="$service->nom" :badge="$service->appointement_count"  :icon="$service->label.' pr-1'"/>
                @endforeach

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <i class="fas fa-microscope pr-3"></i>
                    <b>Analyse</b>
                </li>
                <x-menu-link :link="route('analyse.demandes')" label="Analyses demandées" icon="pr-1 icon-doc" />
                <x-menu-link :link="route('analyse.analyse_appointement_list')" label="Analyses en cours" icon="pr-1 icon-doc" />
                <x-menu-link :link="route('analyse.termines')" label="Analyses terminées" icon="pr-1 icon-doc" />
                <x-menu-link :link="route('analyse.liste')" label="Catalogues" icon="pr-1 icon-folder-alt" />

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <i class="fas fa-prescription-bottle-medical pr-3"></i>
                    <b>Pharmacie</b>
                </li>
                <x-menu-link :link="route('pharmacie.list_ordonance')" label="Ordonances" icon="pr-1 icon-notebook" />
                <x-menu-link :link="route('pharmacie.stock')" label="Stock Medicament" icon="pr-1 icon-layers" />

                <li class="menu-title bg-gray-100 border-2 border-green">
                    <i class="fas fa-prescription-bottle-medical pr-3"></i>
                    <b>Paramètres</b>
                </li>
                <x-menu-link :link="route('user-resource')" label="Utilisateurs" icon="pr-1 icon-users" />

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
