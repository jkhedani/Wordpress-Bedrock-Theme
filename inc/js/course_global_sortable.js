jQuery(document).ready(function($) {    
  
  // Sortable custom post types (Units, Modules, Lessons)
  var sortableUnits = $('#toc-units');
  sortableUnits.sortable({
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
    }
  });

  var sortableModules = $('#toc-units > li > ul');
  sortableModules.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul, #toc-free-modules',
    opacity: 0.8,
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

  var sortableLessons = $('#toc-units > li > ul > li > ul');
  sortableLessons.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul > li > ul, #toc-free-lessons',
    opacity: 0.8,
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

      ui.item.find('.module_order').html('-');
    }
  });

  // Sortable unattached Modules
  var sortableFreeLessons = $('#toc-free-lessons');
  sortableFreeLessons.sortable({
    axis: 'y',
    connectWith: '#toc-units > li > ul > li > ul',
    //forcePlaceholderSize: true,
    opacity: 0.8,
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

      ui.item.find('.lesson_order').html('-');
    }
  });

});
