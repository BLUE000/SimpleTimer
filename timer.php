<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleTimer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            transition: background-color 0.3s;
        }
        #timer {
            font-size: 48px;
            margin: 20px 0;
            font-family: monospace;
            transition: color 0.3s, text-shadow 0.3s;
        }
        select, button {
            padding: 10px;
            margin: 5px;
            font-size: 16px;
        }
        button {
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .customization {
            margin-top: 20px;
            padding: 15px;
            border-top: 1px solid #ddd;
        }
        .customization h3 {
            margin-top: 0;
        }
        .option-group {
            margin: 15px 0;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .option-title {
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }
        .color-option {
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .color-option label {
            margin-right: 10px;
            flex-grow: 1;
            text-align: left;
        }
        .color-picker {
            width: 50px;
            height: 30px;
            border: none;
            padding: 0;
            cursor: pointer;
        }
        .toggle-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 10px 0;
        }
        .time-selector {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }
        .time-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .time-unit label {
            margin-bottom: 5px;
        }
        .file-input {
            margin: 10px 0;
        }
        .sound-option {
            margin: 10px 0;
            text-align: left;
        }
        .test-sound {
            background-color: #2196F3;
        }
        .test-sound:hover {
            background-color: #0b7dda;
        }
        .file-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .volume-control {
            margin: 15px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .volume-slider {
            width: 70%;
            margin: 0 10px;
        }
        .volume-value {
            min-width: 40px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>タイマー</h1>
        
        <div>
            <button id="startBtn">開始</button>
            <button id="stopBtn" disabled>停止</button>
            <button id="resetBtn">リセット</button>
        </div>
        
        <div id="timer">00:00:00.000</div>
        
        <div id="status"></div>
        
        <div class="customization">
            <h3>カスタマイズ</h3>
            
            <div class="option-group">
                <div class="option-title">タイマー時間設定</div>
                <div class="time-selector">
                    <div class="time-unit">
                        <label for="hours">時間</label>
                        <select id="hours">
                            <?php
                            // 0時間から5時間までのオプションを生成
                            for ($i = 0; $i <= 5; $i++) {
                                echo "<option value=\"$i\">$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="time-unit">
                        <label for="minutes">分</label>
                        <select id="minutes">
                            <?php
                            // 0分から59分までのオプションを生成
                            for ($i = 0; $i <= 59; $i++) {
                                $selected = ($i == 1) ? 'selected' : ''; // デフォルトで1分を選択
                                echo "<option value=\"$i\" $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="time-unit">
                        <label for="seconds">秒</label>
                        <select id="seconds">
                            <?php
                            // 0秒から59秒までのオプションを生成
                            for ($i = 0; $i <= 59; $i++) {
                                echo "<option value=\"$i\">$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="option-group">
                <div class="option-title">通知音設定</div>
                <div class="sound-option">
                    <div>
                        <input type="radio" id="defaultSound" name="soundOption" value="default" checked>
                        <label for="defaultSound">デフォルト音</label>
                    </div>
                    <div>
                        <input type="radio" id="customSound" name="soundOption" value="custom">
                        <label for="customSound">カスタム音声ファイル</label>
                    </div>
                    
                    <div class="file-input" id="customSoundInput" style="display: none;">
                        <input type="file" id="soundFile" accept="audio/*">
                        <div class="file-info">対応形式: MP3, WAV, OGG など</div>
                    </div>
                    
                    <div class="volume-control">
                        <label for="volumeSlider">音量:</label>
                        <input type="range" id="volumeSlider" class="volume-slider" min="0" max="100" value="100">
                        <span id="volumeValue" class="volume-value">100%</span>
                    </div>
                    
                    <button id="testSound" class="test-sound">音をテスト</button>
                </div>
            </div>
            
            <div class="option-group">
                <div class="option-title">表示設定</div>
                <div class="color-option">
                    <label for="bgColor">背景色:</label>
                    <input type="color" id="bgColor" class="color-picker" value="#ffffff">
                </div>
                
                <div class="color-option">
                    <label for="textColor">文字色:</label>
                    <input type="color" id="textColor" class="color-picker" value="#000000">
                </div>
                
                <div class="toggle-option">
                    <label for="outlineToggle">文字の縁取り:</label>
                    <input type="checkbox" id="outlineToggle">
                </div>
                
                <div class="color-option">
                    <label for="outlineColor">縁取りの色:</label>
                    <input type="color" id="outlineColor" class="color-picker" value="#ff0000">
                </div>
            </div>
            
            <button id="applyCustomization">設定を適用</button>
            <button id="resetCustomization">デフォルトに戻す</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hoursSelect = document.getElementById('hours');
            const minutesSelect = document.getElementById('minutes');
            const secondsSelect = document.getElementById('seconds');
            const startBtn = document.getElementById('startBtn');
            const stopBtn = document.getElementById('stopBtn');
            const resetBtn = document.getElementById('resetBtn');
            const timerDisplay = document.getElementById('timer');
            const statusDisplay = document.getElementById('status');
            
            // カスタマイズ要素
            const bgColorPicker = document.getElementById('bgColor');
            const textColorPicker = document.getElementById('textColor');
            const outlineToggle = document.getElementById('outlineToggle');
            const outlineColorPicker = document.getElementById('outlineColor');
            const applyCustomBtn = document.getElementById('applyCustomization');
            const resetCustomBtn = document.getElementById('resetCustomization');
            
            // 音声関連の要素
            const defaultSoundRadio = document.getElementById('defaultSound');
            const customSoundRadio = document.getElementById('customSound');
            const customSoundInput = document.getElementById('customSoundInput');
            const soundFileInput = document.getElementById('soundFile');
            const testSoundBtn = document.getElementById('testSound');
            const volumeSlider = document.getElementById('volumeSlider');
            const volumeValue = document.getElementById('volumeValue');
            
            let timer;
            let startTime;
            let duration;
            let running = false;
            let remainingTime = 0;
            let pauseTime = 0;
            
            // 音声ファイル用の変数
            let customSoundURL = null;
            let customSound = null;
            
            // Web Audio APIのコンテキストを作成
            let audioContext = null;
            
            // デフォルト設定
            const defaultSettings = {
                hours: 0,
                minutes: 1,
                seconds: 0,
                bgColor: '#ffffff',
                textColor: '#000000',
                outlineEnabled: false,
                outlineColor: '#ff0000',
                useCustomSound: false,
                volume: 100  // デフォルト音量を100%に設定（実際は50%に相当）
            };
            
            // 実際の音量を計算する関数（0-100のスライダー値を0-50の実際の音量に変換）
            function calculateActualVolume(sliderValue) {
                return sliderValue / 2;  // 100%のスライダー値は50%の実際の音量に相当
            }
            
            // 音量スライダーの更新イベント
            volumeSlider.addEventListener('input', function() {
                const sliderValue = this.value;
                volumeValue.textContent = sliderValue + '%';
                
                // カスタム音声がある場合は音量を更新（0-1の範囲に正規化）
                if (customSound) {
                    customSound.volume = calculateActualVolume(sliderValue) / 100;
                }
            });
            
            // カスタム音声ファイルの設定表示を切り替える
            customSoundRadio.addEventListener('change', function() {
                if (this.checked) {
                    customSoundInput.style.display = 'block';
                }
            });
            
            defaultSoundRadio.addEventListener('change', function() {
                if (this.checked) {
                    customSoundInput.style.display = 'none';
                }
            });
            
            // 音声ファイルが選択された時の処理
            soundFileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) {
                    return;
                }
                
                // 前回のURLをクリーンアップ
                if (customSoundURL) {
                    URL.revokeObjectURL(customSoundURL);
                }
                
                // ファイルからURLを作成
                customSoundURL = URL.createObjectURL(file);
                customSound = new Audio(customSoundURL);
                
                // 設定されている音量を適用
                customSound.volume = calculateActualVolume(volumeSlider.value) / 100;
                
                statusDisplay.textContent = `音声ファイル "${file.name}" を読み込みました`;
            });
            
            // テスト再生ボタンの処理
            testSoundBtn.addEventListener('click', function() {
                playSound();
                statusDisplay.textContent = '通知音をテスト再生しています';
            });
            
            // ビープ音を再生する関数（Web Audio API使用）
            function playBeep() {
                try {
                    // オーディオコンテキストの初期化（一度だけ）
                    if (!audioContext) {
                        // クロスブラウザ対応
                        const AudioContext = window.AudioContext || window.webkitAudioContext;
                        audioContext = new AudioContext();
                    }

                    // オーディオコンテキストが一時停止している場合は再開
                    if (audioContext.state === 'suspended') {
                        audioContext.resume();
                    }

                    // オシレーターを作成
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();
                    
                    // オシレーターの設定（周波数: 800Hz、波形: 矩形波）
                    oscillator.type = 'square';
                    oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                    
                    // 音量制御（スライダーの値を反映）
                    // 現在の50%を最大値とする（100%のスライダーは実際には50%の音量）
                    // 最大でも60%の音量に制限した上で、さらにその半分を上限とする
                    const actualVolume = calculateActualVolume(volumeSlider.value) / 100 * 0.6;
                    gainNode.gain.setValueAtTime(actualVolume, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 1.0);
                    
                    // オシレーターをゲインノードに接続し、ゲインノードを出力に接続
                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    
                    // ビープ音を鳴らす（開始と停止）
                    oscillator.start(audioContext.currentTime);
                    oscillator.stop(audioContext.currentTime + 1.0);
                    
                    console.log(`ビープ音を再生しました (スライダー値: ${volumeSlider.value}%, 実際の音量: ${calculateActualVolume(volumeSlider.value)}%)`);
                    return true;
                } catch (e) {
                    console.error('ビープ音の生成に失敗しました:', e);
                    return false;
                }
            }
            
            function updateTimerDisplay(timeLeft) {
                const totalMilliseconds = timeLeft;
                
                // 時間を計算
                const hours = Math.floor(totalMilliseconds / 3600000);
                const minutes = Math.floor((totalMilliseconds % 3600000) / 60000);
                const seconds = Math.floor((totalMilliseconds % 60000) / 1000);
                const milliseconds = totalMilliseconds % 1000;
                
                // mm:dd:ss.ms形式でフォーマット
                const formattedTime = 
                    String(hours).padStart(2, '0') + ':' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0') + '.' +
                    String(milliseconds).padStart(3, '0');
                
                timerDisplay.textContent = formattedTime;
                
                // タイマー終了時
                if (totalMilliseconds <= 0) {
                    clearInterval(timer);
                    timerDisplay.textContent = '00:00:00.000';
                    statusDisplay.textContent = 'タイマー終了！';
                    running = false;
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                    
                    // 終了時に音を再生
                    playSound();
                }
            }
            
            // 音声を再生する関数
            function playSound() {
                try {
                    // どの音声を再生するか選択
                    if (customSoundRadio.checked && customSound) {
                        // カスタム音声を再生
                        customSound.pause();
                        customSound.currentTime = 0;
                        
                        // 音量を設定 - 実際の音量に変換
                        customSound.volume = calculateActualVolume(volumeSlider.value) / 100;
                        
                        // プロミスを返すplay()を使用
                        const playPromise = customSound.play();
                        
                        if (playPromise !== undefined) {
                            playPromise.then(_ => {
                                // 再生成功
                                console.log(`カスタム音声の再生に成功しました (スライダー値: ${volumeSlider.value}%, 実際の音量: ${calculateActualVolume(volumeSlider.value)}%)`);
                            }).catch(error => {
                                console.error('カスタム音声の再生に失敗しました:', error);
                                statusDisplay.textContent = 'カスタム音声の再生に失敗しました、代替音を使用します';
                                
                                // フォールバック: ビープ音を鳴らす
                                playBeep();
                            });
                        }
                    } else {
                        // デフォルト音声（ビープ音）を再生
                        const beepSuccess = playBeep();
                        
                        if (!beepSuccess) {
                            statusDisplay.textContent = '通知音の再生に失敗しました';
                        }
                    }
                } catch (e) {
                    console.error('音声再生中に例外が発生しました:', e);
                    statusDisplay.textContent = '音声の再生に失敗しました';
                }
            }
            
            function startTimer() {
                if (running) return;
                
                const hours = parseInt(hoursSelect.value) || 0;
                const minutes = parseInt(minutesSelect.value) || 0;
                const seconds = parseInt(secondsSelect.value) || 0;
                
                // 時、分、秒をミリ秒に変換
                duration = (hours * 3600 + minutes * 60 + seconds) * 1000;
                
                if (duration <= 0) {
                    statusDisplay.textContent = '時間を設定してください';
                    return;
                }
                
                if (remainingTime <= 0) {
                    remainingTime = duration;
                }
                
                startTime = Date.now();
                running = true;
                
                startBtn.disabled = true;
                stopBtn.disabled = false;
                statusDisplay.textContent = 'タイマー実行中...';
                
                timer = setInterval(function() {
                    const elapsed = Date.now() - startTime;
                    remainingTime = remainingTime - elapsed;
                    
                    if (remainingTime <= 0) {
                        remainingTime = 0;
                        updateTimerDisplay(0);
                        clearInterval(timer);
                        running = false;
                        startBtn.disabled = false;
                        stopBtn.disabled = true;
                        statusDisplay.textContent = 'タイマー終了！';
                        
                        // 終了時に音を再生
                        playSound();
                    } else {
                        updateTimerDisplay(remainingTime);
                        startTime = Date.now();
                    }
                }, 10); // 10ミリ秒ごとに更新（滑らかな表示のため）
            }
            
            function stopTimer() {
                if (!running) return;
                
                clearInterval(timer);
                running = false;
                pauseTime = remainingTime;
                
                startBtn.disabled = false;
                stopBtn.disabled = true;
                statusDisplay.textContent = 'タイマー停止中';
            }
            
            function resetTimer() {
                clearInterval(timer);
                running = false;
                remainingTime = 0;
                
                startBtn.disabled = false;
                stopBtn.disabled = true;
                timerDisplay.textContent = '00:00:00.000';
                statusDisplay.textContent = 'タイマーをリセットしました';
            }
            
            // カスタマイズ設定を適用する関数
            function applyCustomization() {
                // 背景色を適用
                document.body.style.backgroundColor = bgColorPicker.value;
                
                // 文字色を適用
                timerDisplay.style.color = textColorPicker.value;
                
                // 縁取りを適用
                if (outlineToggle.checked) {
                    timerDisplay.style.textShadow = `
                        -1px -1px 0 ${outlineColorPicker.value},
                        1px -1px 0 ${outlineColorPicker.value},
                        -1px 1px 0 ${outlineColorPicker.value},
                        1px 1px 0 ${outlineColorPicker.value}
                    `;
                } else {
                    timerDisplay.style.textShadow = 'none';
                }
                
                statusDisplay.textContent = 'カスタマイズを適用しました';
            }
            
            // デフォルト設定に戻す関数
            function resetCustomization() {
                // デフォルト値に戻す
                hoursSelect.value = defaultSettings.hours;
                minutesSelect.value = defaultSettings.minutes;
                secondsSelect.value = defaultSettings.seconds;
                bgColorPicker.value = defaultSettings.bgColor;
                textColorPicker.value = defaultSettings.textColor;
                outlineToggle.checked = defaultSettings.outlineEnabled;
                outlineColorPicker.value = defaultSettings.outlineColor;
                defaultSoundRadio.checked = true;
                customSoundRadio.checked = false;
                customSoundInput.style.display = 'none';
                volumeSlider.value = defaultSettings.volume;
                volumeValue.textContent = defaultSettings.volume + '%';
                
                // 適用
                document.body.style.backgroundColor = defaultSettings.bgColor;
                timerDisplay.style.color = defaultSettings.textColor;
                timerDisplay.style.textShadow = 'none';
                
                statusDisplay.textContent = 'デフォルト設定に戻しました';
            }
            
            // イベントリスナー
            startBtn.addEventListener('click', startTimer);
            stopBtn.addEventListener('click', stopTimer);
            resetBtn.addEventListener('click', resetTimer);
            
            // カスタマイズボタンのイベントリスナー
            applyCustomBtn.addEventListener('click', applyCustomization);
            resetCustomBtn.addEventListener('click', resetCustomization);
        });
    </script>
</body>
</html>