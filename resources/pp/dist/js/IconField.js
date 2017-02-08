'use strict';

var IconField = React.createClass({
    displayName: 'IconField',

    logToConsole: function logToConsole(function_name, message_to_log) {
        if (message_to_log) {
            console.log('IconField' + '.' + function_name + ' - ' + message_to_log);
        } else {
            console.log('IconField' + '.' + function_name);
        }
    },
    render: function render() {
        this.logToConsole('render');
        return React.createElement(
            'div',
            null,
            React.createElement(
                'h1',
                null,
                'IconField'
            )
        );
    }
});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIkljb25GaWVsZC5qc3giXSwibmFtZXMiOlsiSWNvbkZpZWxkIiwiUmVhY3QiLCJjcmVhdGVDbGFzcyIsImxvZ1RvQ29uc29sZSIsImZ1bmN0aW9uX25hbWUiLCJtZXNzYWdlX3RvX2xvZyIsImNvbnNvbGUiLCJsb2ciLCJyZW5kZXIiXSwibWFwcGluZ3MiOiI7O0FBQUEsSUFBSUEsWUFBWUMsTUFBTUMsV0FBTixDQUFrQjtBQUFBOztBQUM5QkMsa0JBQWMsc0JBQVVDLGFBQVYsRUFBeUJDLGNBQXpCLEVBQ2Q7QUFDSSxZQUFJQSxjQUFKLEVBQ0E7QUFDSUMsb0JBQVFDLEdBQVIsQ0FBWSxjQUFjLEdBQWQsR0FBb0JILGFBQXBCLEdBQW9DLEtBQXBDLEdBQTRDQyxjQUF4RDtBQUNILFNBSEQsTUFLQTtBQUNJQyxvQkFBUUMsR0FBUixDQUFZLGNBQWMsR0FBZCxHQUFvQkgsYUFBaEM7QUFDSDtBQUNKLEtBWDZCO0FBWTlCSSxZQUFRLGtCQUNSO0FBQ0ksYUFBS0wsWUFBTCxDQUFrQixRQUFsQjtBQUNBLGVBQ0k7QUFBQTtBQUFBO0FBQ0k7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQURKLFNBREo7QUFLSDtBQXBCNkIsQ0FBbEIsQ0FBaEIiLCJmaWxlIjoiSWNvbkZpZWxkLmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIEljb25GaWVsZCA9IFJlYWN0LmNyZWF0ZUNsYXNzKHtcclxuICAgIGxvZ1RvQ29uc29sZTogZnVuY3Rpb24gKGZ1bmN0aW9uX25hbWUsIG1lc3NhZ2VfdG9fbG9nKVxyXG4gICAge1xyXG4gICAgICAgIGlmIChtZXNzYWdlX3RvX2xvZylcclxuICAgICAgICB7XHJcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKCdJY29uRmllbGQnICsgJy4nICsgZnVuY3Rpb25fbmFtZSArICcgLSAnICsgbWVzc2FnZV90b19sb2cpO1xyXG4gICAgICAgIH1cclxuICAgICAgICBlbHNlXHJcbiAgICAgICAge1xyXG4gICAgICAgICAgICBjb25zb2xlLmxvZygnSWNvbkZpZWxkJyArICcuJyArIGZ1bmN0aW9uX25hbWUpO1xyXG4gICAgICAgIH1cclxuICAgIH0sXHJcbiAgICByZW5kZXI6IGZ1bmN0aW9uICgpXHJcbiAgICB7XHJcbiAgICAgICAgdGhpcy5sb2dUb0NvbnNvbGUoJ3JlbmRlcicpO1xyXG4gICAgICAgIHJldHVybiAoXHJcbiAgICAgICAgICAgIDxkaXY+XHJcbiAgICAgICAgICAgICAgICA8aDE+SWNvbkZpZWxkPC9oMT5cclxuICAgICAgICAgICAgPC9kaXY+XHJcbiAgICAgICAgKTtcclxuICAgIH1cclxufSk7Il19
