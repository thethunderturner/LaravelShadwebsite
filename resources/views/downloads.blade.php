<x-layout title="Downloads" description="Here you can find the latest released version of shadPS4 emulator">
    <div class="mx-auto flex max-w-7xl flex-col gap-12">
        {{-- Qt Launcher --}}
        <x-downloads.section
            title="shadPS4 Qt launcher (GUI)"
            :release-date="$qtReleaseDate"
            info="This Qt launcher contains only the GUI of the emulator. All releases and the latest pre-release of shadPS4 can be downloaded from the launcher itself, making it much easier to test different versions of the emulator."
        >
            <x-downloads.os-card
                name="Windows"
                icon="images/os/Windows.png"
                description="Download the latest version for Windows."
                :download="$latestQt['windows'] ?? null"
                button-color="blue"
            />
            <x-downloads.os-card
                name="Linux"
                icon="images/os/Linux.png"
                description="Download the latest version for Linux."
                :download="$latestQt['linux'] ?? null"
                button-color="green"
            />
            <x-downloads.os-card
                name="macOS"
                icon="images/os/MacOS.png"
                description="Download the latest version for macOS."
                :download="$latestQt['macos'] ?? null"
                button-color="red"
            />
        </x-downloads.section>

        {{-- CLI --}}
        <x-downloads.section
            title="shadPS4 Releases"
            :release-date="$cliReleaseDate"
            info="These releases only contain the emulator executable, without any GUI. You will have to run the emulator from the terminal. Prefer the Qt launcher above unless you know what you're doing."
        >
            @if ($cliVersions->isNotEmpty())
                <x-slot:headerAction>
                    <form method="GET" action="{{ route('downloads') }}" class="flex items-center gap-x-2">
                        <label for="version" class="text-text/70 text-sm">Version</label>
                        <select
                            id="version"
                            name="version"
                            onchange="this.form.submit()"
                            class="bg-root border-border text-text rounded-md border px-3 py-1.5 text-sm"
                        >
                            @foreach ($cliVersions as $version)
                                <option value="{{ $version }}" @selected($version === $selectedVersion)>
                                    {{ $version }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </x-slot:headerAction>
            @endif

            <x-downloads.os-card
                name="Windows"
                icon="images/os/Windows.png"
                :description="isset($selectedCli['windows']) ? 'Download '.$selectedVersion.' (CLI) for Windows.' : 'Not available'"
                :download="$selectedCli['windows'] ?? null"
                button-color="blue"
            />
            <x-downloads.os-card
                name="Linux"
                icon="images/os/Linux.png"
                :description="isset($selectedCli['linux']) ? 'Download '.$selectedVersion.' (CLI) for Linux.' : 'Not available'"
                :download="$selectedCli['linux'] ?? null"
                button-color="green"
            />
            <x-downloads.os-card
                name="macOS"
                icon="images/os/MacOS.png"
                :description="isset($selectedCli['macos']) ? 'Download '.$selectedVersion.' (CLI) for macOS.' : 'Not available'"
                :download="$selectedCli['macos'] ?? null"
                button-color="red"
            />
        </x-downloads.section>
    </div>
</x-layout>
