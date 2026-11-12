<script>
(function (window, $) {
  if (!$) return;

  var basePth = <?php echo json_encode(isset($pth) && $pth !== '' ? $pth : '../../'); ?>;

  window.emsNotify = {
    send: function (payload) {
      return $.ajax({
        url: basePth + 'imports/notification/send_notification.php',
        type: 'POST',
        data: payload,
        dataType: 'json'
      });
    },

    // Broadcast to everyone (Admins + Employees)
    sendToAll: function (title, body, imagePth) {
      return this.send({
        type: 'all',
        audience: 'all',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Send to All Employees / Staff
    sendToEmployees: function (title, body, imagePth) {
      return this.send({
        type: 'employees',
        audience: 'employees',
        category: 'employees',
        subscription_id: 'employees',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Send to Administrators
    sendToAdmins: function (title, body, imagePth) {
      return this.send({
        type: 'admins',
        audience: 'admins',
        category: 'admins',
        subscription_id: 'admins',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Send to a specific employee by their user_id
    sendToSpecificEmployee: function (userId, title, body, imagePth) {
      return this.send({
        type: 'specific_member',
        target_user_id: userId,
        target_member_user_id: userId,
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Leave Request notification
    sendLeaveNotice: function (title, body, imagePth) {
      return this.send({
        type: 'leave',
        audience: 'leave',
        category: 'leave',
        subscription_id: 'leave',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Document Request notification
    sendDocumentNotice: function (title, body, imagePth) {
      return this.send({
        type: 'document',
        audience: 'document',
        category: 'document',
        subscription_id: 'document',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Daily Work Plan notification
    sendDailyPlanNotice: function (title, body, imagePth) {
      return this.send({
        type: 'daily_plan',
        audience: 'daily_plan',
        category: 'daily_plan',
        subscription_id: 'daily_plan',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Task Management notification
    sendTaskNotice: function (title, body, imagePth) {
      return this.send({
        type: 'task',
        audience: 'task',
        category: 'task',
        subscription_id: 'task',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Salary Payment notification
    sendSalaryNotice: function (title, body, imagePth) {
      return this.send({
        type: 'salary',
        audience: 'salary',
        category: 'salary',
        subscription_id: 'salary',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Attendance notification
    sendAttendanceNotice: function (title, body, imagePth) {
      return this.send({
        type: 'attendance',
        audience: 'attendance',
        category: 'attendance',
        subscription_id: 'attendance',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Generic category/subscription sender
    sendToCategory: function (category, title, body, imagePth) {
      return this.send({
        type: category || 'all',
        audience: category || 'all',
        category: category || '',
        subscription_id: category || '',
        title: title,
        body: body,
        image_pth: imagePth || ''
      });
    },

    // Backward-compatibility aliases
    sendToMembers: function (title, body, imagePth) {
      return this.sendToEmployees(title, body, imagePth);
    },
    sendToManagers: function (title, body, imagePth) {
      return this.sendToAdmins(title, body, imagePth);
    },
    sendToSubscription: function (subId, title, body) {
      return this.sendToCategory(subId, title, body, '');
    }
  };

  window.neoNotify = window.emsNotify;
  window.bmjmNotify = window.emsNotify;
})(window, window.jQuery);
</script>
