var engine; //Variable to store instance of ScriptEngine Instance

function project_function() // script function for  Web Functional Tester project NewProject5
{
	var webtest = engine.createWebTest();
	webtest.setRecordThinkTime(true);
	webtest.setDefaultThinkTime(1);
	webtest.setSavePageImage(true);
	webtest.setUseSameTimeOut(false);
	webtest.setTreatTimeOutAsFailed(false);
	webtest.setTimeout(15);
	webtest.setRecordFlex(false);
	webtest.setIgnoreThinkTimeWhileReplaying(true);
	webtest.setSaveSuccessfulResponseDetails(false);
	webtest.setIterateTestForAllParameterCombinations(false);
	webtest.setNoOfIterations(1);
	webtest.setRunProjectOnMultipleMachines(false);
	webtest.setRunCrossBrowsers(false);
	webtest.setReplayLinkedProjects(false);
	webtest.addLinkProjectGroup('NewProject5', 'ActionGroup1', false, 1);
	var group = webtest.addActionGroup('ActionGroup1', IWebGroup.GROUP_HTTP);
	group.setStartingURL('http://localhost:8080/Encryptech/index.php');
	group.setIgnored(false);
	group.setRepeatCount(1);
	group.setLaunchNewBrowser(true);
	group.setAuthenticationMechanism(IWebGroup.NO_AUTHENTICATION);
	group.setAuthenticationDomainName('');
	group.setUseUrlRewritingSessionManagement(false);
	group.setUseClientSSLAuthentication(false);
	group.setProxyWhileReplaying(false);
}

function global_validation(url)
{
}

function group_1() // script function for ActionGroup1
{
}
