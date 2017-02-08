var IconField = React.createClass({
    logToConsole: function (function_name, message_to_log)
    {
        if (message_to_log)
        {
            console.log('IconField' + '.' + function_name + ' - ' + message_to_log);
        }
        else
        {
            console.log('IconField' + '.' + function_name);
        }
    },
    render: function ()
    {
        this.logToConsole('render');
        return (
            <div>
                <h1>IconField</h1>
            </div>
        );
    }
});