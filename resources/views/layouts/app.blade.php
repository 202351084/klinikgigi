<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cahaya Dental Care' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        clinic: {
                            cream: '#f7f3e8',
                            sage: '#cfd6aa',
                            moss: '#8a9760',
                            mint: '#32c7bb',
                            teal: '#1d9f97',
                            aqua: '#53d5cb',
                            ink: '#244144',
                            sand: '#ece5cf',
                            line: '#d8d2bd',
                        },
                    },
                },
            },
        };
    </script>
    <style>
        body{font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;margin:0;background:linear-gradient(180deg,#eef3db 0%,#f8f4ea 38%,#fffdf8 100%);color:#244144}
        a{text-decoration:none;color:inherit} .container{max-width:1180px;margin:0 auto;padding:20px}
        .nav,.panel{background:#fff;border:1px solid #d7e3e7;border-radius:16px}
        .nav{display:flex;justify-content:space-between;align-items:center;padding:16px 24px;margin:20px auto;max-width:1100px}
        .menu{display:flex;gap:18px;flex-wrap:wrap}.btn{display:inline-block;background:#127c72;color:#fff;padding:10px 16px;border-radius:10px;border:none;cursor:pointer}
        .btn-secondary{background:#e7f3f1;color:#127c72}.hero{display:grid;grid-template-columns:1.4fr 1fr;gap:24px;align-items:center}
        .grid{display:grid;gap:20px}.grid-2{grid-template-columns:repeat(2,1fr)}.grid-3{grid-template-columns:repeat(3,1fr)}
        .panel{padding:24px}.muted{color:#5d747b}.field{display:grid;gap:8px;margin-bottom:16px}.field input,.field textarea,.field select{padding:12px;border:1px solid #c9d8dc;border-radius:10px;width:100%;box-sizing:border-box}
        .table{width:100%;border-collapse:collapse}.table th,.table td{padding:12px;border-bottom:1px solid #dfe7ea;text-align:left;vertical-align:top}
        .card{background:#fff;border:1px solid #d7e3e7;border-radius:16px;padding:20px}.stat{font-size:28px;font-weight:700}.flash{padding:12px 16px;border-radius:10px;background:#e9f8ee;color:#18643a;margin-bottom:16px}
        .error{color:#a62323;font-size:14px}.badge{display:inline-block;padding:4px 8px;border-radius:999px;background:#e7f3f1;color:#127c72;font-size:12px}
        img.media{max-width:100%;border-radius:14px;display:block}
        @media (max-width: 800px){.hero,.grid-2,.grid-3{grid-template-columns:1fr}.nav{margin:0;border-radius:0}.container{padding:16px}}
    </style>
</head>
<body>
    @yield('body')
    @stack('scripts')
</body>
</html>
