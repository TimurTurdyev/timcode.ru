<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Ошибка') — timcode.ru</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { background: #000; }
        body {
            background: #000000;
            color: #c8c8c8;
            font-family: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', 'Courier New', monospace;
            font-size: 15px;
            line-height: 1.7;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.25rem;
        }
        .wrap {
            width: 100%;
            max-width: 640px;
        }
        .term {
            border: 1px solid #222;
            background: rgba(255, 255, 255, 0.012);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        .term::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, #ff87af, transparent 60%);
            opacity: 0.7;
        }
        .term-head {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 1rem;
            padding-bottom: 0.65rem;
            border-bottom: 1px solid #1a1a1a;
        }
        .term-dot {
            width: 8px; height: 8px;
            background: #ff87af;
            border-radius: 50%;
            animation: pulse 1.6s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.35; }
        }
        .code {
            font-size: 4.75rem;
            font-weight: 700;
            color: #ff87af;
            letter-spacing: -2px;
            line-height: 1;
            margin-bottom: 1rem;
            user-select: none;
        }
        .code::before {
            content: '> ';
            color: #666;
            font-weight: 400;
        }
        .msg {
            font-size: 1.05rem;
            color: #c8c8c8;
            margin-bottom: 0.5rem;
        }
        .hint {
            color: #666;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
            line-height: 1.75;
        }
        .trace {
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid #1a1a1a;
            color: #666;
            font-size: 0.72rem;
            line-height: 1.85;
        }
        .trace-line { color: #404040; }
        .trace-line .accent { color: #5fffff; }
        .trace-line .danger { color: #ff87af; }
        .actions {
            margin-top: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }
        .btn {
            color: #666;
            font-size: 0.78rem;
            border: 1px solid #222;
            padding: 0.4rem 0.85rem;
            text-decoration: none;
            transition: color 0.15s, border-color 0.15s, background 0.15s;
            font-family: inherit;
            background: transparent;
            cursor: pointer;
        }
        .btn:hover {
            color: #87ff87;
            border-color: #87ff87;
            background: rgba(135, 255, 135, 0.08);
            text-decoration: none;
        }
        .cursor {
            display: inline-block;
            color: #ff87af;
            animation: blink 1.1s step-end infinite;
            margin-left: 0.15em;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0; }
        }
        .meta {
            margin-top: 1rem;
            color: #404040;
            font-size: 0.7rem;
            letter-spacing: 0.04em;
            text-align: center;
        }
        .meta a { color: #666; text-decoration: none; }
        .meta a:hover { color: #87ff87; }
        @media (max-width: 540px) {
            body { font-size: 14px; padding: 1rem; }
            .term { padding: 1.1rem; }
            .code { font-size: 3.25rem; letter-spacing: -1px; }
            .msg { font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        @isset($__devPreview)
            <div style="border: 1px dashed #ffd7af; color: #ffd7af; padding: 0.4rem 0.75rem; font-size: 0.72rem; letter-spacing: 0.05em; margin-bottom: 1rem; display: inline-block;">DEV PREVIEW · @yield('code')</div>
        @endisset
        <div class="term">
            <div class="term-head">
                <span class="term-dot"></span>
                <span>system :: fault</span>
            </div>
            <div class="code">@yield('code')</div>
            <div class="msg">@yield('message')</div>
            @hasSection('hint')
                <div class="hint">@yield('hint')</div>
            @endif
            @hasSection('trace')
                <div class="trace">@yield('trace')</div>
            @endif
            <div class="actions">
                <a href="/" class="btn">← на главную</a>
                <a href="mailto:borodatimur@gmail.com?subject=timcode.ru%20—%20ошибка" class="btn">сообщить о проблеме</a>
            </div>
            <div style="margin-top: 0.85rem; color: #404040; font-size: 0.72rem;">ожидание восстановления<span class="cursor">_</span></div>
        </div>
        <div class="meta">timcode.ru · {{ now()->format('Y-m-d H:i') }}</div>
    </div>
</body>
</html>
