<ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-apps') }}"></use>
            </svg> {{ __('Хянах самбар') }}</a></li>
    <li class="nav-title">Үндсэн тоноглол</li>
    <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
        <svg class="nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-factory') }}"></use>
        </svg>
        {{-- <img class="nav-icon" src="{{ asset('icons/noun-electric-factory.svg') }}" /> --}}
        Дэд станц</a>
    <ul class="nav-group-items compact">
        <li class="nav-item"><a class="nav-link" href="{{ route('stations.index') }}"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Дэд станц</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('equipment.index') }}"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Үндсэн тоноглол</a></li>
    </ul>
    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
        {{-- <svg class="nav-icon">
            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-timeline"></use>
        </svg>  --}}
        <img class="nav-icon" src="{{ asset('icons/tower.svg') }}" />
        ЦДАШ
    </a>
    <ul class="nav-group-items compact">
        <li class="nav-item"><a class="nav-link" href="{{ route('powerlines.index') }}"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> ЦДАШ-ын мэдээлэл</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Шугамын түүх</a></li>
    </ul>
    <li class="nav-item"><a class="nav-link" href="{{ route('user_tier_research.index') }}">
        <i class="fas fa-user-tie nav-icon"></i>
        {{ __('I-II судалгаа') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('business-plans.index') }}">
        <i class="far fa-calendar-alt nav-icon"></i>
        {{ __('Бизнес төлөвлөгөө') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('outage_schedules.index') }}">
        <i class="fas fa-calendar-check nav-icon"></i>
        {{ __('Таслалт график') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('protection-zone-violations.index') }}">
        <i class="fas fa-exclamation-triangle nav-icon"></i>
        {{ __('Хамгаалалтын зурвас') }}</a></li>
    {{-- <li class="nav-item"><a class="nav-link" href="">
        <i class="far fa-bell nav-icon"></i>
        {{ __('Олон жилийн график') }}</a></li> --}}
    
</li>
    <li class="nav-title">Журнал</li>
    <li class="nav-item"><a class="nav-link" href="" onclick="return false;">
        <i class="fab fa-creative-commons-nd nav-icon"></i>
        {{ __('Захиалгын бүртгэл') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('power_outages.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
            </svg> {{ __('Тасралт') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('power_cuts.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
            </svg> {{ __('Таслалт') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('power_failures.index') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
            </svg> {{ __('Гэмтэл') }}</a></li>
    <li class="nav-item"><a class="nav-link" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-library') }}"></use>
            </svg> {{ __('Тайлан') }}</a></li>
    <li class="nav-title">Тохиргоо</li>
    <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle') }}"></use>
            </svg> Лавлах сан</a>
        <ul class="nav-group-items compact">
            <li class="nav-item"><a class="nav-link" href="{{ route('branches.index') }}"><span class="nav-icon"><span
                            class="nav-icon-bullet"></span></span> Салбар</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('volts.index') }}"><span class="nav-icon"><span
                            class="nav-icon-bullet"></span></span> Хүчдлийн түвшин</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('equipment-types.index') }}"><span class="nav-icon"><span
                            class="nav-icon-bullet"></span></span> Тоноглолын төрөл</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('protections.index') }}"><span class="nav-icon"><span
                            class="nav-icon-bullet"></span></span> Хамгаалалт</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('cause_outages.index') }}"><span class="nav-icon"><span
                            class="nav-icon-bullet"></span></span> Тасралт шалтгаан</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('cause_cuts.index') }}"><span class="nav-icon"><span
                            class="nav-icon-bullet"></span></span> Таслалт шалтгаан</a></li>
        </ul>
    </li>
    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">
        <svg class="nav-icon">
            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
        </svg> {{ __('Хэрэглэгч') }}</a></li>
</ul>
