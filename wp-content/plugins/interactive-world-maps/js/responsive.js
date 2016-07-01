jQuery(window).on('resize orientationChanged', function() {
if (typeof drawVisualization == 'function') {
  drawVisualization();
} 
});