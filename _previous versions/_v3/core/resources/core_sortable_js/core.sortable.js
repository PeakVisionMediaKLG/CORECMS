sortable('.js-sortable-table', {
    items: "tr.js-sortable-tr",
    handle: ".js-sortable-handle",
    placeholder: "<tr><td colspan=\"9\" style=\"background-color:lightgreen;\"><span class=\"center\">&nbsp;</span></td></tr>",
    forcePlaceholderSize: false
  });
  sortable('.js-sortable-table')[0].addEventListener('sortupdate', function(e) {

  console.log(e.detail);
  
  //alert($('.js-sortable-table').closest("form").serializeArray());
  //console.log($('.js-sortable-table').closest("form").serializeArray());

  //alert($('.js-sortable-table').data('path'));
  coreAction($('.js-sortable-table'),1);
  /*
  This event is triggered when the user stopped sorting and the DOM position has changed.

  e.detail.item - {HTMLElement} dragged element

  Origin Container Data
  e.detail.origin.index - {Integer} Index of the element within Sortable Items Only
  e.detail.origin.elementIndex - {Integer} Index of the element in all elements in the Sortable Container
  e.detail.origin.container - {HTMLElement} Sortable Container that element was moved out of (or copied from)
  e.detail.origin.itemsBeforeUpdate - {Array} Sortable Items before the move
  e.detail.origin.items - {Array} Sortable Items after the move

  Destination Container Data
  e.detail.destination.index - {Integer} Index of the element within Sortable Items Only
  e.detail.destination.elementIndex - {Integer} Index of the element in all elements in the Sortable Container
  e.detail.destination.container - {HTMLElement} Sortable Container that element is moved into (or copied into)
  e.detail.destination.itemsBeforeUpdate - {Array} Sortable Items before the move
  e.detail.destination.items - {Array} Sortable Items after the move
  */
  });  