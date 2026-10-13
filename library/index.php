<?php
require "db.php"; require "auth.php"; requireLogin();
$user_id = currentUserId();
$stmt=$pdo->prepare("SELECT profile_pic FROM users WHERE id=?"); $stmt->execute([$user_id]); $me=$stmt->fetch();
$books = $pdo->query("SELECT * FROM books ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>MindVault</title><link rel="stylesheet" href="style.css"></head><body>
<div class="sidebar"><div class="logo">📚 <span>Mind</span>Vault</div><div class="nav"><a class="active" href="index.php">🏠 Home</a><a href="explore.php">🔍 Explore</a><a href="library.php">📖 My Library</a><a href="community.php">💬 Community</a><a href="profile.php">👤 Profile</a><a href="write.php">✍️ Write a Book</a><a href="logout.php" style="margin-top:auto;color:#ff8a8a">🚪 Logout</a></div></div>
<div class="main">
<div class="topbar"><div class="search"><span style="position:absolute;left:14px;top:50%;transform:translateY(-50%)">🔍</span><input id="searchInput" oninput="searchBooks(this.value)" placeholder="Search books, authors, category..."></div><div style="display:flex;gap:12px;align-items:center"><span style="color:var(--muted)">Hi, <?=htmlspecialchars($_SESSION['username'])?></span><img src="<?=htmlspecialchars($me['profile_pic'] ?? 'https://i.pravatar.cc/40')?>" style="width:36px;height:36px;border-radius:50%;object-fit:cover"></div></div>
<p id="search-msg" style="color:var(--muted);font-size:13px;margin-bottom:8px"></p>
<div class="hero card"><div><h1>A Universe of Books<br>at Your Fingertips</h1><p>Discover, read, and share thousands of books.</p><br><a href="explore.php" class="btn">Explore Now</a></div><img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=400" style="width:280px;height:180px;object-fit:cover;border-radius:16px"></div>
<h3 style="margin:22px 0 10px">Trending Now</h3>
<div class="grid"><?php foreach(array_slice($books,0,8) as $b): ?><div class="book" data-title="<?=htmlspecialchars($b['title'])?>" data-author="<?=htmlspecialchars($b['author'])?>" data-category="<?=htmlspecialchars($b['category'])?>"><img src="<?=htmlspecialchars($b['cover_url'])?>"><div class="info"><h4><?=htmlspecialchars($b['title'])?></h4><p><?=htmlspecialchars($b['author'])?></p><div style="margin-top:8px;display:flex;gap:6px"><button class="btn" style="padding:6px 10px;font-size:12px" onclick="addToLibrary(<?=$b['id']?>)">+ Library</button><a class="btn btn-outline" style="padding:6px 10px;font-size:12px" href="read.php?id=<?=$b['id']?>">Read</a></div></div></div><?php endforeach; ?></div>
</div><script src="assets/js/app.js"></script></body></html>
