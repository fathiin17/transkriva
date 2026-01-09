<x-app-layout>
    <x-slot name="header">
    <header class="bg-gradient-to-r from-[#0f172a] via-[#1e3a8a] to-[#2563eb] shadow-lg"></header>
        <div class="flex items-center gap-4">

    <!-- SAPAAN USER -->
    <span class="text-gray-300 text-sm">
        Hi, <span class="text-white font-semibold">{{ Auth::user()->name }}</span>
    </span>

    <!-- DROPDOWN AKUN -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center gap-2 px-4 py-2
                   bg-white/10 hover:bg-white/20
                   rounded-xl text-gray-200 text-sm
                   transition">
            Akun
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- MENU -->
        <div x-show="open" @click.outside="open = false"
             class="absolute right-0 mt-2 w-44
                    bg-white rounded-xl shadow-lg z-50">

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 text-sm hover:bg-gray-100 rounded-t-xl">
                Profil
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm
                               text-red-600 hover:bg-red-50 rounded-b-xl">
                    Logout
                </button>
            </form>
        </div>
    </div>

</div>

    </x-slot>

    <div class="py-8 max-w-5xl mx-auto space-y-10">

        <!-- 🎤 RECORD SECTION -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        🎙️ Rekam Suara
    </h3>

            <div class="flex gap-4 mb-6">
               <button id="recordBtn"
    class="flex items-center justify-center gap-2 px-6 py-3
           bg-red-500 hover:bg-red-600
           text-black font-semibold rounded-xl transition shadow">
    🎤 Mulai Rekam
</button>



                <button id="stopBtn" disabled
    class="flex items-center justify-center gap-2 px-6 py-3
           bg-gray-200 text-gray-700
           rounded-xl transition shadow">
    ⏹ Hentikan
</button>

            </div>

            <form id="uploadForm" method="POST" action="{{ route('recordings.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <input type="text" name="title" placeholder="Judul rekaman"
                    class="w-full rounded-xl border-none px-4 py-3 text-black placeholder-gray-500 focus:ring-2 focus:ring-indigo-500">

                <textarea name="notes" rows="2" placeholder="Catatan tambahan (opsional)"
                    class="w-full rounded-xl border-none px-4 py-3 text-black placeholder-gray-500 focus:ring-2 focus:ring-indigo-500"></textarea>

                <textarea id="transcript" name="transcript" rows="4"
                    placeholder="Hasil transkripsi suara akan muncul di sini..."
                    class="w-full rounded-xl px-4 py-3 text-black placeholder-gray-500 bg-white focus:ring-2 focus:ring-indigo-500"></textarea>

                <input type="file" name="audio" id="audioInput" hidden>

                <button
                    class="w-full bg-indigo-700 hover:bg-indigo-800 py-3 rounded-xl font-bold transition">
                    💾 Simpan Rekaman
                </button>
            </form>
        </div>

        <!-- 📂 RECORDING LIST -->
        <div>
            <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                📂 Rekaman Saya
            </h3>

            @forelse($recordings as $rec)
                <div class="bg-white rounded-2xl shadow-md p-6 mb-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-lg">{{ $rec->title }}</h4>
                            <p class="text-xs text-gray-400 mt-1">
    📅 {{ $rec->created_at->format('d M Y, H:i') }}
</p>

                            @if($rec->notes)
                                <p class="text-sm text-gray-500 mt-1">{{ $rec->notes }}</p>
                            @endif
                        </div>

                        <div x-data="{ open: false }">

    <!-- TOMBOL HAPUS -->
    <button @click="open = true"
        class="text-red-500 hover:text-red-700 text-sm">
        🗑 Hapus
    </button>

    <!-- MODAL -->
    <div x-show="open"
         x-transition
         class="fixed inset-0 z-50 flex items-center justify-center">

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-black/50"
             @click="open = false"></div>

        <!-- BOX MODAL -->
        <div class="relative bg-white rounded-2xl shadow-xl
                    w-full max-w-md p-6 z-30">

            <h3 class="text-lg font-bold text-gray-800 mb-2">
                Hapus Rekaman?
            </h3>

            <p class="text-sm text-gray-600 mb-6">
                Rekaman yang dihapus tidak dapat dikembalikan.
                Apakah kamu yakin ingin menghapusnya?
            </p>

            <div class="flex justify-end gap-3">

                <button @click="open = false"
                    class="px-4 py-2 rounded-xl
                           bg-gray-100 hover:bg-gray-200
                           text-sm transition">
                    Batal
                </button>

                <!-- FORM HAPUS ASLI -->
                <form method="POST"
                      action="{{ route('recordings.destroy', $rec->id) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="px-4 py-2 rounded-xl
                               bg-red-600 hover:bg-red-700
                               text-white text-sm transition">
                        Ya, Hapus
                    </button>
                </form>

            </div>
        </div>
    </div>

</div>


                    </div>

                    <audio controls class="w-full mt-4">
                        <source src="{{ asset('storage/'.$rec->file_path) }}">
                    </audio>

                    @if($rec->transcript)
                        <div class="mt-4 bg-gray-100 rounded-xl p-4 text-sm">
                            <span class="font-semibold">📝 Transkrip:</span>
                            <p class="mt-1 text-gray-800">{{ $rec->transcript }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-500">Belum ada rekaman.</p>
            @endforelse
        </div>
    </div>

    <footer class="text-center text-xs text-gray-400 py-4">
    © 2025 Transkriva
</footer>


    <!-- SCRIPT -->
    <script>
        let mediaRecorder;
        let audioChunks = [];
        let recognition;

        function startSpeech() {
            if (!('webkitSpeechRecognition' in window)) {
                alert('Browser tidak mendukung Speech Recognition');
                return;
            }

            recognition = new webkitSpeechRecognition();
            recognition.lang = 'id-ID';
            recognition.continuous = true;
            recognition.interimResults = true;

            recognition.onresult = function(event) {
                let text = '';
                for (let i = event.resultIndex; i < event.results.length; i++) {
                    text += event.results[i][0].transcript;
                }
                document.getElementById('transcript').value = text;
            };

            recognition.start();
        }

        function stopSpeech() {
            if (recognition) recognition.stop();
        }

        document.getElementById('recordBtn').onclick = async () => {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.start();
            startSpeech();

            audioChunks = [];
            mediaRecorder.ondataavailable = e => audioChunks.push(e.data);

            document.getElementById('recordBtn').disabled = true;
            document.getElementById('stopBtn').disabled = false;
        };

        document.getElementById('stopBtn').onclick = () => {
            mediaRecorder.stop();
            stopSpeech();

            mediaRecorder.onstop = () => {
                const blob = new Blob(audioChunks, { type: 'audio/webm' });
                const file = new File([blob], 'recording.webm');

                const input = document.getElementById('audioInput');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
            };

            document.getElementById('recordBtn').disabled = false;
            document.getElementById('stopBtn').disabled = true;
        };
    </script>
</x-app-layout>
