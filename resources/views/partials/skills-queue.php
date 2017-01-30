<section ng-controller="SkillsController" class="bp-card">
	<table class="table">
		<thead>
			<tr>
				<td>Skill</td>
				<td>Description</td>
				<td>Training complete</td>
			</tr>
		</thead>
		<tr ng-repeat="skill in skills">
			<td>{{skill.skillDetail.typeName}} Level {{skill.finished_level}}</td>
			<td>{{skill.skillDetail.description}}</td>
			<td>{{skill.finish_date | date:"dd/MM/yyyy 'at' h:mma" }}</td>
		</tr>
	</table>
</section>