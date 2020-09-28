( function( blocks, i18n, editor, element, components ) {
  wp.blocks.registerBlockType('naturfreunde-block/aktivitaeten', {
    title: 'Aktivitäten',
    icon: 'palmtree',
    category: 'naturfreunde-block',
    edit: function(props) {
      return React.createElement('div', {style: {width: "100%", backgroundColor: "silver", padding: "5px", textAlign: "center"}}, 'Platzhalter Aktivitäten');
    },
    save: function(props) {
      return element.createElement('div', null, '[naturfreunde type="aktivitaeten"]');
    }
  });
  wp.blocks.registerBlockType('naturfreunde-block/aktuelles', {
    title: 'Aktuelles',
    icon: 'palmtree',
    category: 'naturfreunde-block',
    edit: function(props) {
      return React.createElement('div', {style: {width: "100%", backgroundColor: "silver", padding: "5px", textAlign: "center"}}, 'Platzhalter Aktuelles');
    },
    save: function(props) {
      return element.createElement('div', null, '[naturfreunde type="aktuelles"]');
    }
  });
  wp.blocks.registerBlockType('naturfreunde-block/haeuser', {
    title: 'Häuser',
    icon: 'palmtree',
    category: 'naturfreunde-block',
    edit: function(props) {
      return React.createElement('div', {style: {width: "100%", backgroundColor: "silver", padding: "5px", textAlign: "center"}}, 'Platzhalter Häuser');
    },
    save: function(props) {
      return element.createElement('div', null, '[naturfreunde type="haeuser"]');
    }
  });
} )(
  window.wp.blocks,
  window.wp.i18n,
  window.wp.editor,
  window.wp.element,
  window.wp.components
);
