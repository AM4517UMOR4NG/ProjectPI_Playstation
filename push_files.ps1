$files = git status --porcelain | ForEach-Object { $_.Substring(3) }
$total = $files.Count
$current = 0

foreach ($file in $files) {
    $current++
    Write-Host "[$current/$total] Processing: $file" -ForegroundColor Cyan
    
    # Add the file
    git add $file
    
    # Create commit message based on file path
    $filename = Split-Path $file -Leaf
    $commitMsg = "update: $filename"
    
    # Commit
    git commit -m $commitMsg
    
    # Push
    git push origin main
    
    Write-Host "[$current/$total] Pushed: $file" -ForegroundColor Green
    Write-Host ""
}

Write-Host "Done! Pushed $total files." -ForegroundColor Yellow
