// Tooltip con cambio fijo (10seg), fuera (5seg)
const tooltip = document.getElementById('tooltip');

function showTooltip() {
    tooltip.style.display = 'block';
}

function hideTooltip() {
    tooltip.style.display = 'none';
}

setInterval(() => {
    showTooltip();
    setTimeout(hideTooltip, 5000);
}, 10000);


// Tooltip fijo
/* const tooltip = document.getElementById('tooltip');

tooltip.style.display = 'block';
 */