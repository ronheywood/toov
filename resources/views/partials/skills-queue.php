<h1><!--Skills Training Queue--></h1>
<section ng-controller="SkillsController" class="bp-card">

	<p>{{completedSkills()}} skills trained</p>
	<table class="table">
		<thead>
			<tr>
				<td>Skill</td>
				<td>Description</td>
				<td>Training complete</td>
			</tr>
		</thead>
		<tr ng-repeat="skill in skills | orderBy: finish_date : false">
			<td>{{skill.skillDetail.typeName}} Level {{skill.finished_level}}</td>
			<td>{{skill.skillDetail.description}}</td>
			<td>{{skill.finish_date | date:"dd/MM/yyyy 'at' h:mma" }}</td>
		</tr>
	</table>
</section>