@props([
    'viewName' => null
])

<nav class="sticky top-0 z-50">
    <section class="relative">
        {{-- Topbar --}}
        <section class="sticky bg-brand-primary-950 py-3 px-2 lg:px-6 flex shadow-lg font-inter">
            {{-- Menu control --}}
            <div class="px-4 flex items-center text-white gap-4 grow">
                <button aria-label="Open sidebar button" title="Open sidebar"
                    x-data
                    @click.stop="document.getElementById('nav_sidebar').classList.add('sidebar_show');"
                    class="p-1 rounded transition-colors cursor-pointer">
                    @svg('zondicon-menu', 'w-5 h-5')
                </button>

                {{-- Current view indicator --}}
                <div class="">
                    <h2 class="text-lg font-medium">{{ $viewName }}</h2>
                </div>
            </div>

            {{-- Widgets --}}
            <div class="grow hidden md:flex items-center justify-end">

                {{-- Profile --}}
                <div class="relative cursor-pointer" x-data="{ isOpen: false }" @click="isOpen = !isOpen" @click.away="isOpen = false">
                    <div class="flex items-center justify-end px-2 gap-3 min-w-[180px]">
                        <div class="text-white font-normal text-sm">
                            <span>{{ Auth::user()->username  }} ({{ Auth::user()->role }})</span>
                        </div>
                        {{-- dropdown toggle icon --}}
                        <div>
                            <button class="text-white p-1">
                                @svg('fluentui-caret-down-12', 'w-3 h-3')
                            </button>
                        </div>
                    </div>

                    {{-- popup --}}
                    <div class="absolute top-full left-0 w-full bg-white rounded shadow-lg" x-show="isOpen" x-transition x-cloak>
                        <ul class="p-2 [&>*]:p-1 [&>*]:rounded-sm [&_*]:cursor-pointer text-sm">
                            <li class="hover:bg-gray-200">
                                <a href="{{ route('profile') }}" class="block w-full p-1">
                                    <span class="flex items-center gap-1">
                                        @svg('fluentui-person-12', 'w-5 h-5')
                                        My Profile
                                    </span>
                                </a>
                            </li>
                            <li class="hover:bg-red-300 hover:text-red-400">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left p-1">
                                        <span class="flex items-center gap-1">
                                            @svg('fluentui-arrow-exit-20', 'w-5 h-5')
                                            Logout
                                        </span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </section>

        {{-- Sidebar --}}
        <section
            id="nav_sidebar"
            class="sidebar flex flex-col items-center justify-start z-50 bg-white fixed top-0 left-0 h-screen shadow-lg p-4 w-full md:max-w-xs"
            x-data
            @click.away="if ($el.classList.contains('sidebar_show')) { $el.classList.remove('sidebar_show'); }"
            >
            {{-- top --}}
            <div class="w-full flex items-center justify-between md:justify-end">
                <img class="mb-2 h-15 object-contain block md:hidden" src="{{ asset('images/reftec_logo_transparent.png') }}">

                <button title="Close sidebar"
                    x-data
                    @click="document.getElementById('nav_sidebar').classList.remove('sidebar_show');"
                    class="flex items-center justify-center cursor-pointer py-1 px-2 gap-2 rounded hover:bg-accent-darkslategray-400 transition-colors">
                    @svg('zondicon-close', 'w-3 h-3')
                    Close
                </button>
            </div>

            {{-- middle--}}
            <div class="w-full grow p-4 flex flex-col overflow-y-auto">
                <img class="mb-2 w-full h-30 object-contain hidden md:block" src="{{ asset('images/reftec_logo_transparent.png') }}">

                <div
                    class="flex flex-col gap-1 [&>*]:text-sm [&>*]:flex [&>*]:items-center [&>*]:gap-2 [&>*]:rounded [&>*]:hover:bg-brand-primary-100/75 [&>*]:transition-colors [&>*]:py-3 [&>*]:px-3">
                    @php
                        $active_link_class_indicator = 'text-accent-orange-300 font-medium';
                        $sidebar_links = [
                            [
                                'route' => route('dashboard'),
                                'label' => 'Dashboard',
                                'active_name' => 'Dashboard',
                                'icon' => 'fluentui-board-28-o',
                            ],
                            [
                                'route' =>  route('content'),
                                'label' => 'Content',
                                'active_name' => 'Content',
                                'icon' => 'fluentui-content-view-28-o',
                            ],
                            [
                                'route' => route('site_monitor'),
                                'label' => 'Site Monitor',
                                'active_name' => 'Site Monitor',
                                'icon' => 'fluentui-camera-dome-28-o',
                            ],
                            [
                                'route' => route('cartrack'),
                                'label' => 'Cartrack',
                                'active_name' => 'Cartrack',
                                'icon' => 'fluentui-vehicle-car-28-o',
                            ],
                            [
                                'route' => route('users'),
                                'label' => 'Users',
                                'active_name' => 'Users',
                                'icon' => 'fluentui-person-28-o',
                            ],
                            [
                                'route' => route('logs'),
                                'label' => 'Logs',
                                'active_name' => 'Logs',
                                'icon' => 'fluentui-document-endnote-24-o',
                            ],
                            [
                                'route' => route('files'),
                                'label' => 'Files',
                                'active_name' => 'Files',
                                'icon' => 'fluentui-folder-28-o',
                            ],
                        ];
                    @endphp
                    @foreach ($sidebar_links as $link)
                        <a href="{{ $link['route'] }}" title="{{ $link['label'] }}"
                            @if($viewName === $link['active_name'])
                                class="{{ $active_link_class_indicator }}"
                            @endif
                            >
                            @svg($link['icon'], 'w-5 h-5')
                            <span class="grow">{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- footer --}}
            <footer class="w-full flex item-center justify-between md:hidden">
                <div class="flex items-center justify-start text-sm">
                    <a href="{{ route('profile') }}" title="View profile"
                        class="grow truncate flex items-center gap-1 hover:underline">
                        @svg('fluentui-person-12', 'w-4 h-4')
                        <p class="truncate">{{ Auth::user()->username }} ({{ Auth::user()->role }})</p>
                    </a>
                </div>
                <div class="">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout"
                            class="scale-75 flex items-center justify-center px-2 py-1 cursor-pointer bg-brand-secondary-200 hover:bg-brand-secondary-300 text-brand-secondary-400 hover:text-brand-secondary-600 transition-colors rounded">
                            @svg('fluentui-arrow-exit-20', 'w-5 h-5')
                            Logout
                        </button>
                    </form>
                </div>
            </footer>
        </section>


    </section>
</nav>

