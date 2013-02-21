jQuery(document).ready(function($) {    


  // Sortable custom post types (Units, Modules, Lessons)
  var sortableUnits = $('#toc-units');
  sortableUnits.sortable({
    handle: '.handle',
    update: function(event, ui) {
      $('#loading-animation').show(); // Show the animate loading gif while waiting
      
      // Update Unit numbers in database
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_update_global_sortable_unit', // Tell WordPress how to handle this ajax request
          order: sortableUnits.sortable('toArray').toString(), // Passes ID's of list items in 1,3,2 format
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      // Update Unit numbering
      ui.item.parent().children().each(function(index) {
        $('.unit_order', this).html(index+1);
      });
    },
    remove: function(event, ui) {
      alert("asbt");
    }
  });


  var sortableModules = $('#toc-units > li > ul');
  sortableModules.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul', //, #toc-free-modules',
    opacity: 0.8,
    handle: '.handle',
    update: function(event, ui) {
      $('#loading-animation').show(); // Show the animate loading gif while waiting

      // Update Module numbers in database
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_update_global_sortable_module', // Tell WordPress how to handle this ajax request
          order: ui.item.parent().sortable('toArray').toString(), // Passes ID's of list items in 1,3,2 format
          parent_id: ui.item.parent().attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      // Update Module numbering
      ui.item.parent().children().each(function(index) {
        $('.module_order', this).html(index+1);
      });
    },
    remove: function(event, ui) {
      $('#loading-animation').show(); // Show the animate loading gif while waiting

      // Update Module numbers in database
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_update_global_sortable_module', // Tell WordPress how to handle this ajax request
          order: $(event.target).sortable('toArray').toString(), // Passes ID's of list items in 1,3,2 format
          parent_id: $(event.target).attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      // Update Module numbering
      $(event.target).children().each(function(index) {
        $('.module_order', this).html(index+1);
      });
    },
    receive: function(event, ui) {
      $('#loading-animation').show();
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_receive_global_sortable_module', // Tell WordPress how to handle this ajax request
          module_id: ui.item.attr('id'),
          parent_id: ui.item.parent().attr('id'),
          old_parent_id: ui.sender.attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);
    }
  });


  var sortableLessons = $('#toc-units > li > ul > li > ul, #toc-free-modules > li > ul');
  sortableLessons.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul > li > ul', //, #toc-free-lessons',
    opacity: 0.8,
    handle: '.handle',
    update: function(event, ui) {
      $('#loading-animation').show(); // Show the animate loading gif while waiting
      
      // Update Lesson numbering in database
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_update_global_sortable_lesson', // Tell WordPress how to handle this ajax request
          order: ui.item.parent().sortable('toArray').toString(), // Passes ID's of list items in 1,3,2 format
          parent_id: ui.item.parent().attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      // Update Lesson numbering
      ui.item.parent().children().each(function(index) {
        $('.lesson_order', this).html(index+1);
      });
    },
    remove: function(event, ui) {
      $('#loading-animation').show(); // Show the animate loading gif while waiting
      
      // Update Lesson numbering in database
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_update_global_sortable_lesson', // Tell WordPress how to handle this ajax request
          order: $(event.target).sortable('toArray').toString(), // Passes ID's of list items in 1,3,2 format
          parent_id: $(event.target).attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      // Update Lesson numbering
      $(event.target).children().each(function(index) {
        $('.lesson_order', this).html(index+1);
      });
    },
    receive: function(event, ui) {
      $('#loading-animation').show();
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_receive_global_sortable_lesson', // Tell WordPress how to handle this ajax request
          lesson_id: ui.item.attr('id'),
          parent_id: ui.item.parent().attr('id'),
          old_parent_id: ui.sender.attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);
    }
  });


  // Sortable unattached Modules
  var sortableFreeModules = $('#toc-free-modules');
  sortableFreeModules.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul',
    opacity: 0.8,
    handle: '.handle',
    receive: function(event, ui) {
      $('#loading-animation').show();
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_detach_global_sortable_module', // Tell WordPress how to handle this ajax request
          module_id: ui.item.attr('id'),
          old_parent_id: ui.sender.attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      //ui.item.find('.module_order').html('-');
    }
  });


  // Sortable unattached Modules
  var sortableFreeLessons = $('#toc-free-lessons');
  sortableFreeLessons.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul > li > ul',
    //forcePlaceholderSize: true,
    opacity: 0.8,
    handle: '.handle',
    receive: function(event, ui) {
      $('#loading-animation').show();
      opts = {
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data:{
          action: 'course_detach_global_sortable_lesson', // Tell WordPress how to handle this ajax request
          lesson_id: ui.item.attr('id'),
          old_parent_id: ui.sender.attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      };
      $.ajax(opts);

      //ui.item.find('.lesson_order').html('-');
    }
  });


  // Enable X button for detaching modules and lessons (i.e., placing them in the unattached modules/lessons bucket)
  $('.toplevel_page_global-sort #wpbody li span.detach').click(function() {
    $($(this).siblings('ul').find('span.detach').get().reverse()).trigger('click'); // detach any children first, starting from the end (so the toc doesn't try to renumber when removing the first item)
    var removedFrom = $(this).parent().parent();
    var removedItem = $(this).parent();

    if ($(this).hasClass('detach-module')) {
      // Move the detached module down to the unattached modules sortable
      $(this).parent().prependTo('#toc-free-modules');
      // Trigger receive event on detached modules sortable
      //$('#toc-free-modules').sortable('widget').trigger("receive", null, uiHash);
      $('#loading-animation').show();
      $.ajax({
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data: {
          action: 'course_detach_global_sortable_module', // Tell WordPress how to handle this ajax request
          module_id: removedItem.attr('id'),
          old_parent_id: removedFrom.attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates to the detached module.');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      });
      // Remove module number from item display
      //$(this).find('.module_order').html('-');

    } else if ($(this).hasClass('detach-lesson')) {
      // Move the detached lesson down to the unattached lessons sortable
      $(this).parent().prependTo('#toc-free-lessons');
      // Trigger receive event on detached lessons sortable
      //$('#toc-free-lessons').sortable("widget").trigger("receive", null, uiHash);
      $('#loading-animation').show();
      $.ajax({
        url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
        type: 'POST',
        async: true,
        cache: false,
        dataType: 'json',
        data: {
          action: 'course_detach_global_sortable_lesson', // Tell WordPress how to handle this ajax request
          lesson_id: removedItem.attr('id'),
          old_parent_id: removedFrom.attr('id'),
        },
        success: function(response) {
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        },
        error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
          alert('There was an error saving the updates to the detached lesson.');
          $('#loading-animation').hide(); // Hide the loading animation
          return; 
        }
      });
      // Remove lesson number from item display
      //$(this).find('.lesson_order').html('-');
    }

    // Trigger remove event on the parent sortable for the item that was removed
    //widget = removedFrom.sortable("widget");
    //if (widget) widget.trigger("remove", eventHash, uiHash);
    $('#loading-animation').show(); // Show the animate loading gif while waiting
    // Update numbering in database
    $.ajax({
      url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
      type: 'POST',
      async: true,
      cache: false,
      dataType: 'json',
      data: {
        action: 'course_update_global_sortable_lesson', // Tell WordPress how to handle this ajax request
        order: removedFrom.sortable('toArray').toString(), // Passes ID's of list items in 1,3,2 format
        parent_id: removedFrom.attr('id'),
      },
      success: function(response) {
        $('#loading-animation').hide(); // Hide the loading animation
        return; 
      },
      error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
        alert('There was an error saving the updates to the table of contents.');
        $('#loading-animation').hide(); // Hide the loading animation
        return; 
      }
    });
    // Update numbering
    removedFrom.children().each(function(index) {
      // If our removedFrom parent is a module sortable, then renumber the modules (otherwise renumber lessons)
      if ($('.module_order', this).length > 0)
        $('.module_order', this).html(index+1);
      else
        $('.lesson_order', this).html(index+1);
    });

  });

});
