tree = ast.parse(userInput)
for stmt in tree.body:
    if isinstance(stmt, _ast.FunctionDef):
        if stmt.name != functionName:
            print("Incorrect function name")
        if set(it.id for it in stmt.args.args) != parameterNames:
            print("Incorrect variable names")
        if needsLoop and not any(isinstance(fctStmt, (_ast.For, _ast.While)) for fctStmt in stmt.body):
            print("Missing loop")
        break
else:
    print("Missing function")
