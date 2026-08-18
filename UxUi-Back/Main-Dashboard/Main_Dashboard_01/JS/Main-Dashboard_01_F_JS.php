<script>
  /* ===================================================================
     Main-Dashboard_01_F_JS.php — Member Street List JS logic
     Wellawatta Jumma Mosque · Admin Dashboard (Dash-Board-01-F)
     =================================================================== */

  let memberStreetData = [
    // { id: "1", road_name: "Road 1" },
    // { id: "2", road_name: "Road 2" },
    // { id: "3", road_name: "Road 3" },
    // { id: "4", road_name: "Road 4" },
    // { id: "5", road_name: "Road 5" },
    // { id: "6", road_name: "Galle Road" },
    // { id: "7", road_name: "Station Road" },
    // { id: "8", road_name: "Mosque Lane" }
  ];

  function memberStreetRender() {
    const searchInput = document.getElementById('member-street-search');
    const q = searchInput ? searchInput.value.trim().toLowerCase() : '';
    const list = document.getElementById('member-street-list');
    const empty = document.getElementById('member-street-empty');

    if (!list) return;

    // Filter local active dataset
    const filtered = memberStreetData.filter(function(item) {
      const name = (typeof item === 'object' ? (item.road_name || item.name || '') : item).toString().toLowerCase();
      return !q || name.includes(q);
    });

    if (filtered.length === 0) {
      list.innerHTML = '';
      if (empty) empty.style.display = 'block';
    } else {
      if (empty) empty.style.display = 'none';
      list.innerHTML = filtered.map(function(item) {
        const roadName = typeof item === 'object' ? (item.road_name || item.name || '') : item;
        const roadId = typeof item === 'object' ? (item.id || '') : '';
        return `<div class="member-street-row">
          <span class="member-street-name">${escapeHtml(roadName)}</span>
          <button class="member-street-select" onclick="memberStreetSelect('${escapeJsString(roadName)}', '${roadId}')">Select</button>
        </div>`;
      }).join('');
    }
  }

  function fetchMemberRoadsFromDB() {
    const searchInput = document.getElementById('member-street-search');
    const q = searchInput ? searchInput.value.trim() : '';

    $.ajax({
      url: "<?php echo $pth; ?>View-List/Member/road_view.php",
      type: "POST",
      data: { search_txt: q },
      success: function(response) {
        try {
          const json_data = JSON.parse(response);
          if (Array.isArray(json_data) && json_data.length > 0) {
            // Merge DB data with local data, avoiding duplicates
            const existingNames = new Set(json_data.map(i => (i.road_name || '').toLowerCase()));
            const fallbackExtra = memberStreetData.filter(i => {
              const name = (typeof i === 'object' ? (i.road_name || '') : i).toLowerCase();
              return !existingNames.has(name);
            });
            memberStreetData = json_data.concat(fallbackExtra);
            memberStreetRender();
          }
        } catch(e) {
          console.error("Error parsing road list from DB:", e);
        }
      }
    });
  }

  function memberStreetSelect(roadName, roadId) {
    window.selected_member_road_name = roadName;
    window.selected_member_road_id = roadId;

    // Store road name for display
    const nameInput = document.getElementById('selected_member_road');
    if (nameInput) {
      nameInput.value = roadName;
    }

    // Store road ID for DB submission
    const idInput = document.getElementById('add_member_manual_road_id');
    if (idInput) {
      idInput.value = roadId;
    }

    if (typeof main_dashboard_01_G_OPEN === 'function') {
      main_dashboard_01_G_OPEN();
    }
  }

  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function escapeJsString(str) {
    if (!str) return '';
    return String(str).replace(/'/g, "\\'").replace(/"/g, '\\"');
  }

  $(document).ready(function() {
    fetchMemberRoadsFromDB();
    memberStreetRender();
  });
</script>
