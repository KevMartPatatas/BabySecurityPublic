
$proc = Get-Process -Name wslrelay -ErrorAction SilentlyContinue
if ($proc) {
    $usandoPuerto80 = $proc | Where-Object { $_.Id -in (Get-NetTCPConnection -LocalPort 80).OwningProcess }
    if ($usandoPuerto80) {
        Stop-Process -Id $usandoPuerto80.Id -Force
        Write-Output "wslrelay detenido (PID $($usandoPuerto80.Id))."
    } else {
        Write-Output "wslrelay está activo pero no usa el puerto 80."
    }
} else {
    Write-Output "No se encontró ningún proceso llamado wslrelay."
}
