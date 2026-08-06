@props(['interval' => 10000, 'containerId' => 'data-table-card'])

<button type="button" 
        id="livePillBtn" 
        class="badge px-3 py-1.5 font-weight-extrabold shadow-2xs border d-inline-flex align-items-center gap-1.5" 
        style="border-radius: 50rem; font-size: 0.73rem; letter-spacing: 0.04em; cursor: pointer; outline: none !important; user-select: none; background-color: #ecfdf5; color: #047857; border-color: #a7f3d0 !important; transition: all 0.2s ease-in-out;" 
        title="Klik untuk Pause / Resume Auto Refresh">
    <span class="live-dot" id="live-dot"></span>
    <span id="live-text">LIVE (10s)</span>
</button>

<style>
    .live-dot {
        width: 7px;
        height: 7px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: live-pulse 1.8s infinite;
    }
    .live-dot.paused {
        background-color: #94a3b8 !important;
        animation: none !important;
        box-shadow: none !important;
    }
    @keyframes live-pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 5px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const liveBtn = document.getElementById('livePillBtn');
        const liveDot = document.getElementById('live-dot');
        const liveText = document.getElementById('live-text');
        const containerId = "{{ $containerId }}";
        const intervalMs = {{ $interval }};
        let isFetching = false;
        let pollingTimer = null;

        // Remember user setting via localStorage
        const storedState = localStorage.getItem('live_refresh_enabled');
        let isLiveActive = storedState !== null ? (storedState === 'true') : true;

        function setLiveState(active, statusText = null) {
            isLiveActive = active;
            localStorage.setItem('live_refresh_enabled', active ? 'true' : 'false');

            if (active) {
                if (liveBtn) {
                    liveBtn.style.backgroundColor = '#ecfdf5';
                    liveBtn.style.color = '#047857';
                    liveBtn.style.borderColor = '#a7f3d0';
                }
                if (liveDot) liveDot.classList.remove('paused');
                if (liveText) liveText.textContent = statusText || 'LIVE (10s)';
            } else {
                if (liveBtn) {
                    liveBtn.style.backgroundColor = '#f1f5f9';
                    liveBtn.style.color = '#64748b';
                    liveBtn.style.borderColor = '#cbd5e1';
                }
                if (liveDot) liveDot.classList.add('paused');
                if (liveText) liveText.textContent = statusText || 'PAUSED';
            }
        }

        // Apply initial state
        setLiveState(isLiveActive, isLiveActive ? 'LIVE (10s)' : 'PAUSED');

        function checkCanPoll() {
            if (!isLiveActive) return false;
            if (document.hidden) return false;
            if (isFetching) return false;
            
            // Check target card
            const targetCard = document.getElementById(containerId) || document.querySelector('.card-table-target');
            if (!targetCard) return false;

            // Pause if user is typing
            const activeEl = document.activeElement;
            if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'SELECT' || activeEl.tagName === 'TEXTAREA')) {
                return false;
            }
            return true;
        }

        function fetchLatestData() {
            if (!checkCanPoll()) return;

            const targetCard = document.getElementById(containerId) || document.querySelector('.card-table-target');
            if (!targetCard) return;

            isFetching = true;

            fetch(window.location.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(htmlString => {
                isFetching = false;
                if (!checkCanPoll()) return;

                const parser = new DOMParser();
                const doc = parser.parseFromString(htmlString, 'text/html');
                const newCard = doc.getElementById(containerId) || doc.querySelector('.card-table-target');

                if (newCard && targetCard) {
                    targetCard.innerHTML = newCard.innerHTML;
                    const now = new Date();
                    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                    setLiveState(true, `LIVE (${timeStr})`);
                }
            })
            .catch(err => {
                isFetching = false;
                console.log('Live refresh skipped:', err);
            });
        }

        // Toggle state on button click
        if (liveBtn) {
            liveBtn.addEventListener('click', function () {
                if (isLiveActive) {
                    setLiveState(false, 'PAUSED');
                } else {
                    setLiveState(true, 'LIVE (10s)');
                    fetchLatestData();
                }
            });
        }

        // Timer
        pollingTimer = setInterval(fetchLatestData, intervalMs);

        // Tab Change
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                setLiveState(isLiveActive, isLiveActive ? 'TAB INACTIVE' : 'PAUSED');
            } else if (isLiveActive) {
                setLiveState(true, 'LIVE (10s)');
                fetchLatestData();
            }
        });
    });
</script>
