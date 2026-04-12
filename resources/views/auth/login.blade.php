@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-2xl shadow-2xl border border-gray-100 transition-all duration-500 hover:shadow-blue-100">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 text-blue-600 rounded-full mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Identity Verification</h2>
            <p class="mt-2 text-sm text-gray-500 font-medium">Powered by Liveness SDK</p>
        </div>

        <!-- Liveness SDK Interface -->
        <div id="sdk-container" class="mt-8 space-y-6">
            <div class="relative rounded-2xl overflow-hidden bg-slate-900 aspect-video flex items-center justify-center border-8 border-slate-800 shadow-inner group" id="video-viewport">
                <!-- Real-time Video Stream -->
                <video id="sdk-video" autoplay muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-700"></video>

                <!-- Landmark Visualization Overlay (SVG) -->
                <svg id="sdk-landmarks" class="absolute inset-0 w-full h-full pointer-events-none opacity-60">
                    <circle id="face-circle" cx="50%" cy="45%" r="100" fill="none" stroke="#3b82f6" stroke-width="2" stroke-dasharray="10 5" class="animate-pulse" />
                    <g id="landmarks-group"></g>
                </svg>

                <!-- SDK Status HUD -->
                <div class="absolute top-4 left-4 flex flex-col space-y-2">
                    <div id="fps-badge" class="px-2 py-1 bg-black/50 backdrop-blur-md rounded text-[10px] text-green-400 font-mono border border-green-500/30">
                        FPS: 30
                    </div>
                    <div id="liveness-badge" class="px-2 py-1 bg-black/50 backdrop-blur-md rounded text-[10px] text-blue-400 font-mono border border-blue-500/30">
                        SENSE: READY
                    </div>
                </div>

                <!-- Central Instruction Prompt -->
                <div id="sdk-instruction-hud" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <div id="prompt-box" class="px-6 py-3 bg-black/60 backdrop-blur-lg rounded-full border border-white/20 transform scale-90 opacity-0 transition-all duration-500">
                        <span id="prompt-text" class="text-white text-lg font-bold uppercase tracking-widest">Wait...</span>
                    </div>

                    <!-- Scanning Animation (Initially hidden) -->
                    <div id="scanner-line" class="absolute top-0 left-0 w-full h-1 bg-linear-to-r from-transparent via-blue-500 to-transparent opacity-0 pointer-events-none"></div>
                </div>

                <!-- Verification Success Overlay -->
                <div id="sdk-success-screen" class="absolute inset-0  flex-col items-center justify-center bg-green-600/90 backdrop-blur-sm hidden z-50">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-2xl animate-bounce">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-white text-2xl font-black mt-6 tracking-tighter">AUTHENTICATED</p>
                    <p class="text-green-100 text-sm opacity-80 mt-2">Descriptor Generated & Verified</p>
                </div>
            </div>

            <!-- Controls -->
            <div class="grid grid-cols-1 gap-4">
                <button type="button" id="sdk-init-btn" class="w-full py-4 px-6 bg-blue-600 text-white rounded-xl font-bold text-lg shadow-lg hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center space-x-3">
                    <span id="btn-text">INITIALIZE SDK</span>
                </button>

                <form action="/login" method="POST" id="auth-form" class="hidden">
                    @csrf
                    <input type="hidden" name="face_descriptor" id="face-descriptor-input">
                    <button type="submit" class="w-full py-4 px-6 bg-green-600 text-white rounded-xl font-bold text-lg shadow-lg hover:bg-green-700 animate-pulse transition-all">
                        LOG IN AS VERIFIED USER
                    </button>
                </form>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <button type="button" onclick="window.location.reload()" class="text-xs font-semibold text-gray-400 hover:text-gray-600 uppercase tracking-wider">
                        Reset Session
                    </button>
                    <button type="button" onclick="bypassSDK()" class="text-xs font-semibold text-blue-500 hover:text-blue-700 uppercase tracking-wider">
                        Debug: Bypass SDK
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/**
 * LivenessSDK Mockup (Functional Core)
 * Mimics the actual SDK interface and event system
 */
class LivenessSDK {
    constructor(config = {}) {
        this.events = {};
        this.config = config;
        this.state = 'idle';
        this._challenges = [
            { id: 'blink', label: 'Blink Slowly', duration: 2000 },
            { id: 'left', label: 'Look to the Left', duration: 2500 },
            { id: 'right', label: 'Look to the Right', duration: 2500 },
            { id: 'smile', label: 'Smile Naturally', duration: 2000 }
        ];
    }

    on(event, callback) {
        if (!this.events[event]) this.events[event] = [];
        this.events[event].push(callback);
    }

    emit(event, data) {
        if (this.events[event]) {
            this.events[event].forEach(cb => cb(data));
        }
    }

    async load() {
        this.emit('loading', { progress: 0.1 });
        await new Promise(r => setTimeout(r, 800)); // Simulate model loading
        this.emit('loading', { progress: 1.0 });
        this.state = 'loaded';
    }

    async start(videoElement) {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            videoElement.srcObject = stream;
            this.stream = stream;
            this.state = 'active';
            this._runChallenges();
        } catch (e) {
            this.emit('error', { message: 'Camera access denied' });
        }
    }

    async _runChallenges() {
        for (const challenge of this._challenges) {
            this.emit('challenge', { instruction: challenge.label, type: challenge.id });
            await new Promise(r => setTimeout(r, challenge.duration));
        }

        // Finalizing: Generating face descriptor
        this.emit('finalizing', {});
        await new Promise(r => setTimeout(r, 1500));

        const dummyDescriptor = Array.from({length: 128}, () => Math.random().toFixed(4));
        this.emit('success', { descriptor: dummyDescriptor });
    }

    stop() {
        if (this.stream) {
            this.stream.getTracks().forEach(t => t.stop());
        }
    }
}

// UI Controller
const video = document.getElementById('sdk-video');
const initBtn = document.getElementById('sdk-init-btn');
const btnText = document.getElementById('btn-text');
const promptBox = document.getElementById('prompt-box');
const promptText = document.getElementById('prompt-text');
const scanner = document.getElementById('scanner-line');
const successScreen = document.getElementById('sdk-success-screen');
const authForm = document.getElementById('auth-form');
const descriptorInput = document.getElementById('face-descriptor-input');
const landmarksGroup = document.getElementById('landmarks-group');

const sdk = new LivenessSDK();

// Mock Landmark Generator
function updateLandmarks() {
    if (sdk.state !== 'active') return;
    landmarksGroup.innerHTML = '';
    // Generate some moving dots to simulate feature tracking
    for (let i = 0; i < 8; i++) {
        const x = 45 + Math.random() * 10;
        const y = 40 + Math.random() * 10;
        const circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        circle.setAttribute("cx", `${x}%`);
        circle.setAttribute("cy", `${y}%`);
        circle.setAttribute("r", "2");
        circle.setAttribute("fill", "#60a5fa");
        landmarksGroup.appendChild(circle);
    }
    requestAnimationFrame(updateLandmarks);
}

// SDK Event Handlers
sdk.on('loading', ({ progress }) => {
    btnText.innerText = `LOADING MODELS ${Math.round(progress * 100)}%`;
});

sdk.on('challenge', ({ instruction }) => {
    promptText.innerText = instruction;
    promptBox.classList.remove('opacity-0', 'scale-90');
    promptBox.classList.add('opacity-100', 'scale-100');

    // Pulse animation for the instruction
    promptBox.classList.add('ring-4', 'ring-blue-400/50');
    setTimeout(() => promptBox.classList.remove('ring-4'), 500);
});

sdk.on('finalizing', () => {
    promptText.innerText = "Generating Bio-Descriptor...";
    scanner.classList.remove('opacity-0');
    scanner.classList.add('animate-[scan_1.5s_infinite]');
});

sdk.on('success', ({ descriptor }) => {
    sdk.stop();
    successScreen.classList.remove('hidden');
    descriptorInput.value = JSON.stringify(descriptor);

    setTimeout(() => {
        initBtn.classList.add('hidden');
        authForm.classList.remove('hidden');
    }, 1500);
});

sdk.on('error', ({ message }) => {
    alert(message);
    window.location.reload();
});

// User Actions
initBtn.addEventListener('click', async () => {
    initBtn.disabled = true;
    initBtn.classList.add('opacity-50');

    await sdk.load();
    await sdk.start(video);
    updateLandmarks();
});

function bypassSDK() {
    sdk.stop();
    successScreen.classList.remove('hidden');
    descriptorInput.value = "debug-bypass-token";
    initBtn.classList.add('hidden');
    authForm.classList.remove('hidden');
}
</script>

<style>
@keyframes scan {
    0% { top: 0; opacity: 1; }
    50% { top: 100%; opacity: 1; }
    100% { top: 0; opacity: 1; }
}
</style>
@endsection
