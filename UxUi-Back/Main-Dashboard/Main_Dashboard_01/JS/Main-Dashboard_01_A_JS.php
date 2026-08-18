<script type="text/javascript">
  /* ===================================================================
     Main-Dashboard_01_A_JS.php — Member List page logic (WWJM Admin)
     =================================================================== */

  let memberListData = [];

  const memberListMoney = n => n.toLocaleString('en-LK', {minimumFractionDigits:2, maximumFractionDigits:2});

  let memberListPage = 1;

  function fetchMemberDashboardData() {
    $.ajax({
      url: "<?php echo $pth; ?>View-List/member_register/member_dashboard_list_view.php",
      type: "GET",
      success: function(response) {
        try {
          const json_data = JSON.parse(response);
          if (Array.isArray(json_data)) {
            memberListData = json_data;
            memberListRender();
          }
        } catch (e) {
          console.error("Failed to parse member list data:", e);
        }
      },
      error: function(err) {
        console.error("AJAX Error fetching member list:", err);
      }
    });
  }

  function memberListFiltered(){
    const q = document.getElementById('member-list-search').value.trim().toLowerCase();
    const type = document.getElementById('member-list-type').value;
    return memberListData.filter(m=>{
      const matchesName = !q || m.name.toLowerCase().includes(q);
      const matchesType = type === 'all' || m.status === type;
      return matchesName && matchesType;
    });
  }

  function viewMemberDashboard(id) {
    window.location.href = "Admin_user_dashboard.php?id=" + encodeURIComponent(id || '');
  }

  function memberListRowHtml(m){
    const viewBtn = `<button class="member-list-icon-btn-view" title="View Member Details" aria-label="View Member Details" onclick="viewMemberDashboard('${m.id}')">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <line x1="4" y1="6" x2="20" y2="6"/>
        <line x1="4" y1="12" x2="20" y2="12"/>
        <line x1="4" y1="18" x2="20" y2="18"/>
      </svg>
    </button>`;

    const approveBtn = m.status === 'approved'
      ? `<span class="member-list-icon-only" title="Approved">
           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.5 10 17 19 7.5"/></svg>
         </span>`
      : `<button class="member-list-btn-approve" data-round="${m.round || 1}" onclick="memberListApprove(this)">Approve 0${m.round || 1}</button>`;

    return `<tr>
      <td class="member-list-name">${m.name}</td>
      <td class="member-list-address">${m.road}</td>
      <td class="member-list-amount">${memberListMoney(m.amount)}</td>
      <td class="member-list-action-cell">
        <div class="member-list-action-wrap">
          ${viewBtn}
          ${approveBtn}
        </div>
      </td>
    </tr>`;
  }

  function memberListRender(){
    const perPage = parseInt(document.getElementById('member-list-perpage').value, 10);
    const rows = memberListFiltered();
    const totalPages = Math.max(1, Math.ceil(rows.length / perPage));
    memberListPage = Math.min(memberListPage, totalPages);

    const start = (memberListPage - 1) * perPage;
    const pageRows = rows.slice(start, start + perPage);

    const tbody = document.getElementById('member-list-tbody');
    const empty = document.getElementById('member-list-empty');

    if (!tbody || !empty) return; // Wait until DOM is ready if called early

    if(pageRows.length === 0){
      tbody.innerHTML = '';
      empty.style.display = 'block';
    } else {
      empty.style.display = 'none';
      tbody.innerHTML = pageRows.map(memberListRowHtml).join('');
    }

    document.getElementById('member-list-count').textContent =
      rows.length ? `Showing ${start + 1}–${Math.min(start + perPage, rows.length)} of ${rows.length} members` : '0 members';

    memberListRenderPagination(totalPages);
  }

  function memberListRenderPagination(totalPages){
    const nav = document.getElementById('member-list-pagination');
    let html = `<button class="member-list-page-btn" ${memberListPage===1?'disabled':''} onclick="memberListGoTo(${memberListPage-1})">‹</button>`;
    for(let p=1;p<=totalPages;p++){
      html += `<button class="member-list-page-btn ${p===memberListPage?'member-list-page-active':''}" onclick="memberListGoTo(${p})">${p}</button>`;
    }
    html += `<button class="member-list-page-btn" ${memberListPage===totalPages?'disabled':''} onclick="memberListGoTo(${memberListPage+1})">›</button>`;
    nav.innerHTML = html;
  }

  function memberListGoTo(page){
    memberListPage = page;
    memberListRender();
    document.querySelector('.member-list-panel').scrollIntoView({behavior:'smooth', block:'start'});
  }

  function memberListApprove(btn){
    const row = btn.closest('tr');
    btn.outerHTML = `<span class="member-list-icon-only" title="Approved">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.5 10 17 19 7.5"/></svg>
      </span>`;
  }

  function memberListClosePanel(){
    document.querySelector('.member-list-panel').style.display = 'none';
  }

  // Fetch data on load
  document.addEventListener("DOMContentLoaded", function() {
    fetchMemberDashboardData();
  });
</script>
