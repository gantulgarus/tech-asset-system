<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-apps') }}"></use>
            </svg>
            {{ __('Хянах самбар') }}
        </a>
    </li>

    <li class="nav-group {{ request()->routeIs('stations.*') || request()->routeIs('equipment.*') ? 'show' : '' }}" aria-expanded="{{ request()->routeIs('stations.*') || request()->routeIs('equipment.*') ? 'true' : 'false' }}">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-factory') }}"></use>
            </svg>
            Дэд станц
        </a>
        <ul class="nav-group-items" style="height: {{ request()->routeIs('stations.*') || request()->routeIs('equipment.*') ? 'auto;' : '0px;' }}">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('stations.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Дэд станц
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('equipment.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Үндсэн тоноглол
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-group {{ request()->routeIs('powerlines.*') ? 'show' : '' }}" aria-expanded="{{ request()->routeIs('powerlines.*') ? 'true' : 'false' }}">
        <a class="nav-link nav-group-toggle" href="#">
            <img class="nav-icon" src="{{ asset('icons/tower.svg') }}" />
            ЦДАШ
        </a>
        <ul class="nav-group-items" style="height: {{ request()->routeIs('powerlines.*') ? 'auto;' : '0px;' }}">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('powerlines.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    ЦДАШ-ын мэдээлэл
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Шугамын түүх
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('power_outages.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
            </svg>
            {{ __('Тасралт') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('power_cuts.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
            </svg>
            {{ __('Таслалт') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('power_failures.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-notes') }}"></use>
            </svg>
            {{ __('Гэмтэл') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-library') }}"></use>
            </svg>
            {{ __('Тайлан') }}
        </a>
    </li>
    <li class="nav-title">Тохиргоо</li>
    <li class="nav-group {{ request()->routeIs('branches.*') || request()->routeIs('volts.*') ? 'show' : '' }}" aria-expanded="{{ request()->routeIs('branches.*') || request()->routeIs('volts.*') ? 'true' : 'false' }}">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-applications-settings') }}"></use>
            </svg>
            Лавлах сан
        </a>
        <ul class="nav-group-items" style="height: {{ request()->routeIs('branches.*') || request()->routeIs('volts.*') ? 'auto;' : '0px;' }}">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('branches.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Салбар
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('volts.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Хүчдлийн түвшин
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('equipment-types.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Тоноглолын төрөл
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('protections.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Хамгаалалт
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cause_outages.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Тасралт шалтгаан
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('cause_cuts.index') }}" target="_top">
                    <svg class="nav-icon" style="width: 8px; height: 8px;" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="small-white-svg">
                        <path d="m256 8c-137 0-248 111-248 248s111 248 248 248 248-111 248-248-111-248-248-248z"/>
                      </svg>
                    Таслалт шалтгаан
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
            </svg>
            {{ __('Хэрэглэгч') }}
        </a>
    </li>

    
</ul>